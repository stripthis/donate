<?php
/**
 * Manage Tell a Friend
 * 
 * @package 	tellafriend
 * @author 		Mayank Bhramar <mayank.bhramar@enova-tech.net>, Refactorings by Tim Koschuetzki (tim@debuggable.com)
 */
class TellfriendsController extends TellfriendsAppController {
	var $components = array('Caplimit', 'Recaptcha');
	var $uses = array('Akismet', 'Tellfriends.Tellfriend');

	
/**
 * Setting security components e.g. akismet apikey
 *
 * @return void
 * @access public
 */
	function beforeFilter(){
		if (isset($this->js)) {
			$this->set('js', $this->js);
		}
		$this->Akismet->apiKey = '9ae3443b5369';
		$this->Recaptcha->publickey = "6LcYYwgAAAAAAFY60zscq0Oc6Zb1SxxawK6dOip7";
		$this->Recaptcha->privatekey = "6LcYYwgAAAAAAGmtiUbf_Eis_w8HYICZs21eHKCC ";
	}
/**
 * Getting list of e-mail addresses from email providers using openinviter
 *
 * @return  list of e-mail addresses with checkbox as string
 * @access public
 */
	function contactList($email = null, $encodedPass = null, $provider = null){
	
			$errors=array();
			$password = base64_decode($encodedPass);

			App::import('Vendor', 'OpenInviter', array('file' => 'openinviter.php'));
			
			$inviter = new OpenInviter();
			$oi_services=$inviter->getPlugins();
				
			$inviter->startPlugin($provider);
			
			$internal=$inviter->getInternalError();
			if ($internal){
				$errors['inviter']=$internal;
			} elseif(!$inviter->login($email,$password)){
				$internal=$inviter->getInternalError();
				$errors['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later");
			} elseif (false===$contacts=$inviter->getMyContacts()){
				$errors['contacts']="Unable to get contacts."; 
			} else{
			
				$this->render = false;
				$element = '';
				if(count($contacts) >0){
				$element .= "<table>";
					foreach ($contacts as $key=>$val) {
						$element .= '<tr><td  valign="top"><input type="checkbox" name="Tellfriend.option[]" value="'.$key.'" onchange="tellFriends(this);"></td><td valgin="bottom">'.$key.'</td></tr>';
					}
				$element .= '</table><input type="button" id="confirm" value="Confirm" onclick="validate();">';
				 }
				echo $element;
				exit;
			}
			if(count($errors)>0){
				$errMessages = '';
				foreach ($errors as $key=>$val) {
							$errMessages .= $val;
						}
				echo $errMessages;
				exit;
			}

			
	
	}
/**
 * controller action for datepicker view
 *
 * @return void
 * @access public
 */
	function datepicker() {
			return;
		}
/**
 * controller action for openinviter thickbox pop up
 *
 * @return void
 * @access public
 */
	function openinviter() {
			return;
		}
/**
 * controller action for tellafriend feature
 *
 * @return void
 * @access public
 */
	function refer() {
			if ($this->isGet()) {
			return;
		}

		$comment = array('comment_author' => '',

                         'comment_author_email' => $this->data['Tellfriend']['sender'],

                         'comment_content' => $this->data['Tellfriend']['content'],
						 'comment_type'  => 'tell a friend'
						 );
						 
						 
		$result = $this->Akismet->checkComment($comment);
		
		if($result == 'true'){
			echo $msg = 'Message content appears to be spam.';	
			exit;
		}else if($this->Recaptcha->valid($this->params['form'])){
			$allowedCharInEmail = array('@', ',', '.', '-', '_');
			App::import('Sanitize');
			$this->data['Tellfriend']['receiver'] = Sanitize::paranoid(
				$this->data['Tellfriend']['receiver'], $allowedCharInEmail
			);
	
			$toEmail = explode(',', $this->data['Tellfriend']['receiver']);
			array_walk($toEmail, 'trim');
			
			$fromEmail = $this->data['Tellfriend']['sender'];
				
			$saveData = $this->data;
			$saveData['Tellfriend']['ip'] = $this->RequestHandler->getClientIP();
	
			if ($this->Caplimit->checkCaps($toEmail, $fromEmail) == false)  {
				return $this->render('refer_not_allowed');
			}

			if ($this->Tellfriend->saveReference($saveData, $toEmail)) {
				$appName = Configure::read('App.name');
				foreach ($toEmail as $email) {
					$emailSettings = array(
						'vars' => array(
							'mail_message' => $this->data['Tellfriend']['content']
						),
						'mail' => array(
							'to' => $email
							, 'subject' => 'A Friend suggested you check out ' . $appName
						)
					);
					if (Mailer::deliver('tellfriend', $emailSettings)) {
						$this->Tellfriend->saveField('sent', 1);
						$msg = 'Your message has been sent to your friends.';
						return $this->Message->add(__($msg, true), 'ok', true, $this->referer());
					}
					$msg = 'Your message was not sent due to an internal problem. Please try again.';
					$this->Message->add(__($msg, true), 'ok', true, $this->referer());
				}
			}
		} else{
			 $msg = 'The characters you entered didn\'t match the word verification. Please try again.';
			 $this->Message->add(__($msg, true), 'ok', true, $this->referer());
		}
	}
}
?>