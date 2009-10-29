<?php
class BibitController extends BibitfakeAppController {
	var $uses = array('Transaction', 'Card');
	var $helpers = array('GiftForm');
/**
 * undocumented function
 *
 * @param string $tId 
 * @return void
 * @access public
 */
	function result($tId) {
		$transaction = $this->Transaction->find('first', array(
			'conditions' => array(
				'Transaction.id' => $tId
			),
			'contain' => array('Currency(iso_code)'),
		));

		$cardOptions = $this->Card->getTypes();
		$this->set(compact('transaction', 'cardOptions'));

		if ($this->isGet()) {
			return;
		}

		$this->Card->set($this->data);
		if (!$this->Card->validates()) {
			$msg = __('There are problems with the form!', true);
			return $this->Message->add($msg, 'error');
		}

		$this->Transaction->set(array(
			'id' => $this->data['Card']['transaction_id'],
			'status' => 'ok'
		));
		$this->Transaction->save();

		$msg = __('Transaction successful!', true);
		$url = array('controller' => 'gifts', 'action' => 'thanks', 'plugin' => '');
		$this->Message->add($msg, 'ok', true, $url);
	}
}
?>