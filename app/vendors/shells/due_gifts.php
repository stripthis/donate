<?php
ini_set('memory_limit', '1024M');
App::import(array('Model', 'AppModel'));
/**
 * Removes user records under certain conditions
 *
 * @package default
 * @access public
 */
class DueGiftsShell extends Shell {
	var $uses = array('Gift');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$gifts = $this->Gift->find('all', array(
			'conditions' => array(
				'Gift.frequency <>' => 'onetime',
				'Gift.due' => '0',
				'Gift.archived' => '0'
			),
			'contain' => array(
				'LastTransaction'
			),
			'order' => array('Gift.created' => 'desc')
		));

		foreach ($gifts as $gift) {
			$lastProcessed = false;
			if (!empty($gift['LastTransaction'])) {
				$lastProcessed = $gift['LastTransaction']['created'];
			} else {
				$this->makeDue($gift);
				continue;
			}

			switch ($gift['Gift']['frequency']) {
				case 'daily':
					if (strtotime($lastProcessed) + DAY <= time()) {
						$this->makeDue($gift);
						continue;
					}
					break;
				case 'monthly':
					if (strtotime($lastProcessed) + MONTH <= time()) {
						$this->makeDue($gift);
						continue;
					}
					break;
				case 'biannually':
					if (strtotime($lastProcessed) + 6 * MONTH <= time()) {
						$this->makeDue($gift);
						continue;
					}
					break;
				case 'annually':
					if (strtotime($lastProcessed) + YEAR <= time()) {
						$this->makeDue($gift);
						continue;
					}
					break;
			}
		}
	}
/**
 * undocumented function
 *
 * @param string $gift 
 * @return void
 * @access public
 */
	function makeDue($gift) {
		$this->Gift->set(array(
			'id' => $gift['Gift']['id'],
			'due' => '1'
		));
		$this->Gift->save(null, false);
		$this->out('Made "' . $gift['Gift']['name'] . '" due');
	}
}
?>