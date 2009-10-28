<?php
class BibitController extends BibitfakeAppController {
/**
 * undocumented function
 *
 * @param string $tId 
 * @return void
 * @access public
 */
	function result($tId) {
		$this->set(compact('tId'));
	}
/**
 * undocumented function
 *
 * @param string $tId 
 * @return void
 * @access public
 */
	function pass($tId) {
		$Transaction = ClassRegistry::init('Transaction');
		$Transaction->set(array('id' => $tId, 'status' => 'ok'));
		$Transaction->save();

		$this->Message->add(__('Transaction successful!', true), 'ok', true, '/');
	}
}
?>