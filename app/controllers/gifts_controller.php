<?php
class GiftsController extends AppController {
	var $components = array('Wizard');
/**
 * undocumented function
 *
 * @return void
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Appeal = ClassRegistry::init('Appeal');

		$this->Wizard->steps = array('add', 'thanks', 'tell_friends', 'receipt');
		$this->Wizard->sessionKey = 'Gift';

		# wizard redirects must keep current office
		$this->Wizard->wizardAction = '/gifts/';
		$this->Wizard->completeUrl = '/gifts/summary';
	}
/**
 * undocumented function
 *
 * @param string $step 
 * @return void
 */
	function wizard($step = null) {
		switch ($step) {
			case 'add':
				$appealOptions = $this->Appeal->find('list');
				$this->set(compact('appealOptions'));
				break;
			default:
				break;
		}
		$this->Wizard->process($step);
	}
/**
 * undocumented function
 *
 * @return void
 */
	function processAdd() {
		$this->Gift->create($this->data);
		if ($this->Gift->validates()) {
			return true;
		}

		$msg = 'Sorry, something went wrong processing your donation data. ';
		$msg .= 'Please correct the errors below.';
		$this->Message->add($msg, 'error');
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 */
	function processThanks() {
		$this->Client->set($this->data);
		if ($this->Client->validates() ) {
			return true;
		}

		$this->flash('Es ist ein Fehler aufgetreten. Bitte überprüfen Sie Ihre Eingaben noch einmal.');
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 */
	function processTellFriends() {
		$this->Gift->set($this->data);

		if ($this->Gift->validates()) {
			return true;
		}

		$this->flash('Ihre Anfrage konnte nicht gesendet werden. Bitte überprüfen Sie Ihre Eingaben noch einmal.');
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 */
	function processReceipt() {
		$this->Gift->set($this->data);

		if ($this->Gift->validates()) {
			return true;
		}

		$this->flash('Ihre Anfrage konnte nicht gesendet werden. Bitte überprüfen Sie Ihre Eingaben noch einmal.');
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 */
	function _afterComplete() {
		$wizard_data = $this->Wizard->read();

		# massage data
		$this->data = $wizard_data;

		$this->data['Gift'] = am(
			$wizard_data['message']['Gift'],
			$wizard_data['data']['Gift']
		);
		$this->data['Client'] = $wizard_data['password']['Client'];
		$this->data['Message'] = $wizard_data['message']['Message'];

		$this->Gift->createFromWizard($this->data);

		# load data for summary in session
		$this->Session->write('gift', $gift);
	}
/**
 * undocumented function
 *
 * @return void
 */
	function summary() {
		if (!$this->Session->read('gift')) {
			$msg = 'Something went wrong saving the gift.';
			$this->Message->add($msg, 'error', true, '/');
		}

		$gift = $this->Session->read('gift');
		$this->Session->delete('gift');
		$this->set(compact('gift'));
	}
}
?>