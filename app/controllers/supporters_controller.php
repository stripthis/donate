<?php
class SupportersController extends AppController {
	var $helpers = array('Fpdf', 'GiftForm');
	var $components = array('GridFilter');
	var $models = array('Gift', 'Contact', 'Address', 'Phone');
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
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$conditions = array(
			'Gift.office_id' => $this->Session->read('Office.id'),
			'Gift.archived' => '0'
		);

		$order = array('Gift.created' => 'desc');
		switch ($type) {
			case 'signups':
				// doesn't have gift
				break;
			case 'donors':
				// has one gift
				break;
			case 'favorites':
			case 'starred':
				$conditions['Supporter.id'] = $this->Session->read('favorites');
				break;
			case 'archived':
				$conditions['Supporter.archived'] = '1';
				break;
		}

		$defaults = array(
			'keyword' => '',
			'search_type' => 'all',
			'my_limit' => 20,
			'custom_limit' => false,
			'start_date_day' => '01',
			'start_date_year' => date('Y'),
			'start_date_month' => '01',
			'end_date_day' => '31',
			'end_date_year' => date('Y'),
			'end_date_month' => '12'
		);
		$params = am($defaults, $this->params['url'], $this->params['named']);
		unset($params['ext']);
		unset($params['url']);

		if (is_numeric($params['custom_limit'])) {
			if ($params['custom_limit'] > 75) {
				$params['custom_limit'] = 75;
			}
			if ($params['custom_limit'] == 0) {
				$params['custom_limit'] = 50;
			}
			$params['my_limit'] = $params['custom_limit'];
		}

		if (!empty($params['keyword'])) {
			$params['keyword'] = trim($params['keyword']);
			switch ($params['search_type']) {
				case 'gift':
					$conditions['Gift.serial LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'appeal':
					$conditions['Appeal.name LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'person':
					$key = "CONCAT(Contact.fname,' ',Contact.lname)";
					$conditions[$key . ' LIKE'] = '%' . $params['keyword'] . '%';
					break;
				default:
					$conditions['or'] = array(
						'Gift.serial LIKE' => '%' . $params['keyword'] . '%',
						'Appeal.name LIKE' => '%' . $params['keyword'] . '%',
						'Office.name LIKE' => '%' . $params['keyword'] . '%',
						"CONCAT(Contact.fname,' ',Contact.lname) LIKE" => '%' . $params['keyword'] . '%'
					);
					break;
			}
		}

		$conditions = $this->GridFilter->dateRange($conditions, $params, 'Gift', 'created');
		$this->Session->write('gifts_filter_conditions', $conditions);
		$this->paginate['Gift'] = array(
			'conditions' => $conditions,
			'recursive' => 3,
			'contain' => array(
				'Contact(fname, lname, email,created,modified,id)',
				'Transaction(id,status,gateway_id,created,modified)',
				'Transaction.Gateway(id,name)'
			),
			'limit' => $params['my_limit'],
			'order' => $order
		);

		$gifts = $this->paginate();
		$this->set(compact('gifts', 'type', 'params'));
		
		/*
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
		*/
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
		$this->Message->add(__('Successfully deleted!', true), 'ok', true, array('action' => 'index'));
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