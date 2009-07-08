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

		$this->Wizard->steps = array('add', 'login', 'confirm', 'thanks', 'tell_friends', 'receipt');
		$this->Wizard->sessionKey = 'Gift';
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
			case 'confirm':
				$this->data = $this->Session->read('gift');
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
		$this->Gift->set($this->data);
		if ($this->Gift->validates()) {
			if (!$this->data['Gift']['recurring']) {
				unset($this->data['Gift']['start']);
				unset($this->data['Gift']['end']);
				unset($this->data['Gift']['frequency']);
			}
			$this->Session->write('gift', $this->data);
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
 * @access public
 */
	function processConfirm() {
		$this->data = $this->Wizard->read();
		$msg = 'Sorry, this has not been implemented yet.';
		$this->Message->add($msg, 'error');
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 */
	function processThanks() {
		$this->Gift->set($this->data);
		if ($this->Gift->validates()) {
			return true;
		}

		$this->Message->add('Sorry, this has not been implemented yet.', 'error');
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 */
	function processTellFriends() {
		$this->Message->add('Sorry, this has not been implemented yet.', 'error');
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

		$this->Message->add('Sorry, this has not been implemented yet.', 'error');
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 */
	function _afterComplete() {
		$wizard_data = $this->Wizard->read();
		$this->data = $wizard_data;
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