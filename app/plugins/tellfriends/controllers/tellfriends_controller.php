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
		$this->Recaptcha->publickey = Configure::read("App.recaptcha.publicKey");
		$this->Recaptcha->privatekey = Configure::read("App.recaptcha.privateKey");
	}
	/**
 * Getting list of e-mail addresses from email providers using openinviter
 *
 * @return  list of e-mail addresses with checkbox as string
 * @access public
 */
	function contactlist(){
			$errors=array();
			$contacts=array();

			App::import('Vendor', 'OpenInviter', array('file' => 'openinviter.php'));
			
			$inviter = new OpenInviter();
			$oi_services=$inviter->getPlugins();
				
			$inviter->startPlugin($this->data['openinviter']['provider_box']);
			
			$internal=$inviter->getInternalError();
			if ($internal){
				$errors['inviter']=$internal;
			} elseif(!$inviter->login($this->data['openinviter']['email_box'],$this->data['openinviter']['password_box'])){
				$internal=$inviter->getInternalError();
				$errors['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later");
			} elseif (false===$contacts=$inviter->getMyContacts()){
				$errors['contacts']="Unable to get contacts."; 
			} 
			$this->set(compact('contacts'));
			$this->set('sender', $this->data['openinviter']['email_box']);
			$this->set(compact('errors'));
		return;	
	
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
		//render tellfriends page
		if ($this->isGet()) {
			return;
		}

		//Check whether email content is spam
		$comment = array('comment_author' => '',
                         'comment_author_email' => $this->data['Tellfriend']['sender'],
                         'comment_content' => $this->data['Tellfriend']['content'],
						 'comment_type'  => 'tell a friend'
						 );
		$emailContentIsSpam = $this->Akismet->checkComment($comment);
		//Verify recaptcha				 
		$recaptchaVerified = true;	
		if($this->data['tellafriend']['useRecaptcha'] == 1){
			$recaptchaVerified = $this->Recaptcha->valid($this->params['form']);
		}
		if($emailContentIsSpam == 'true'){
			echo $msg = 'Message content appears to be spam.';
			exit;
		}else if($recaptchaVerified){
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
							'message' => $this->data['Tellfriend']['content']
						),
						'mail' => array(
							'to' => $email
							, 'subject' => 'A Friend suggested you check out ' . $appName
						)
					);
					if (Mailer::deliver('tellfriend', $emailSettings)) {
						$this->Tellfriend->saveField('sent', 1);
						$msg = __('Your message has been sent to your friends.', true);
						return $this->Message->add($msg, 'ok', true, $this->referer());
					}
					$msg = __('Your message was not sent due to an internal problem. Please try again.', true);
					return $this->Message->add($msg, 'ok', true, $this->referer());
					
				}
			}
		} else{
			 $msg = __('The characters you entered didn\'t match the word verification. Please try again.', true);
			 return $this->Message->add($msg, 'ok', true, $this->referer());
		}
	}
}
?>