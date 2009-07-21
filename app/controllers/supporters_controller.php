<?php
class SupportersController extends AppController {
	function beforeFilter() {
		parent::beforeFilter();

		$this->User = ClassRegistry::init('User');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['User'] = array(
			'conditions' => array(
				'User.has_donated' => '1'
			),
			'contain' => false,
			'limit' => 20
		);
		$supporters = $this->paginate();
		$this->set(compact('supporters'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id = null) {
		$user = $this->User->find('first', $id);
		$this->User->delete($id);
		$this->Silverpop->UserOptOut($user);
		$this->Message->add(DEFAULT_FORM_DELETE_SUCCESS, 'ok', true, array('action' => 'index'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		$user = $this->User->find('first', array(
			'conditions' => array('User.id' => $id),
			'contain' => array('ScoringHistory')
		));
		$this->set(compact('user'));
	}
}
?>