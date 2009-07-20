<?php
class GiftsController extends AppController {
/**
 * undocumented function
 *
 * @return void
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Appeal = ClassRegistry::init('Appeal');
		$this->Country = ClassRegistry::init('Country');
	}
/**
 * undocumented function
 *
 * @param string $step 
 * @return void
 */
	function add($step = null) {
		$appealOptions = $this->Appeal->find('list');
		$countryOptions = $this->Country->find('list');
		$this->set(compact('appealOptions', 'countryOptions'));

		if ($this->isGet()) {
			return;
		}

		$this->Gift->create($this->data);
		if (!$this->Gift->validates()) {
			$msg = 'Sorry, something went wrong processing your donation data. ';
			$msg .= 'Please correct the errors below.';
			return $this->Message->add($msg, 'error');
		}

		
		// 1. extract payment info
		// 2. load proper gateway
		// 3. process the payment
		// 4. error handling!
		// 5. save gift entry
		// 6. create unique id for the receipt
		pr($this->data);
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function thanks() {
		
	}
}
?>