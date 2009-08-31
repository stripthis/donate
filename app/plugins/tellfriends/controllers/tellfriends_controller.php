<?php
/**
 * Manage Tell a Friend
 * 
 * @package 	tellafriend
 * @author 		Mayank Bhramar <mayank.bhramar@enova-tech.net>, Refactorings by Tim Koschuetzki (tim@debuggable.com)
 * @copyright 	Enova
 */
class TellfriendsController extends TellfriendsAppController {
	var $components = array('Caplimit');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function refer() {
		if ($this->isGet()) {
			return;
		}

		$allowedCharInEmail = array('@', ',', '.', '-', '_');
		App::import('Sanitize');
		$this->data['Tellfriend']['receiver'] = Sanitize::paranoid(
			$this->data['Tellfriend']['receiver'], $allowedCharInEmail
		);

		$toEmail = explode(',', $this->data['Tellfriend']['receiver']);
		array_walk($toEmail, 'trim');

		$saveData = $this->data;
		$saveData['Tellfriend']['ip'] = $this->RequestHandler->getClientIP();

		if ($this->Caplimit->checkCaps($toEmail) == false)  {
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
	}
}
?>