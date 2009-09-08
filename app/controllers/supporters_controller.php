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
	function admin_index($type = 'all') {
		$conditions = array(
			'Gift.office_id' => $this->Session->read('Office.id')
		);
		switch ($type) {
			case 'incomplete_gifts':
				$conditions['Gift.complete'] = '0';
				break;
			case 'complete_gifts':
				$conditions['Gift.complete'] = '1';
				break;
		}
		$this->paginate['Gift'] = array(
			'conditions' => $conditions,
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