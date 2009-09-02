<?php
class SupportersController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->User = ClassRegistry::init('User');
		$this->Gift = ClassRegistry::init('Gift');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['Gift'] = array(
			'contain' => array(
				'Contact(fname, lname, email, salutation, title)',
				'Contact.Address',
				'Office(id, name)',
				'Appeal(id, name)'
			),
			'limit' => 10,
			'order' => array('Gift.created' => 'desc')
		);
		$gifts = $this->paginate('Gift');
		$this->set(compact('gifts', 'keyword', 'type'));
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
			'conditions' => array('User.id' => $id)
		));
		$this->set(compact('user'));
	}
}
?>