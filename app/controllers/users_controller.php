<?php
class UsersController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate = array(
			'conditions' => array(
				'User.login <>' => Configure::read('App.guestAccount')
			),
			'contain' => false
		);
		$users = $this->paginate();
		$this->set(compact('users'));
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
			'contain' => false
		));
		$this->set(compact('user'));
	}
}
?>