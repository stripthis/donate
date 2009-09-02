<?php
ini_set('memory_limit', '512M');
require_once CAKE_TESTS_LIB.'cake_test_model.php';
require_once CAKE_TESTS_LIB.'cake_test_fixture.php';
class CreateReferralKeysShell extends Shell {
	var $uses = array('User');
/**
 * Creates referral keys for all users that don't have one yet
 *
 * @return void
 * @access public
 */
	function main() {
		$users = $this->User->find('all', array(
			'conditions' => array('referral_key' => ''),
			'fields' => array('id')
		));
		$i = 0;
		foreach ($users as $user) {
			$this->User->set(array(
				'id' => $user['User']['id'],
				'referral_key' => $this->User->referral_key($user['User']['id'], true)
			));
			$this->User->save();
			$i++;
		}
		$this->out('Created keys for ' . $i . ' users');
	}
}

?>