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
		$this->Address = ClassRegistry::init('Address');
		$this->Country = $this->Address->Country;
		$this->City = $this->Address->City;
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
			case 'oneoff':
				$conditions['Gift.frequency'] = 'onetime';
				break;
			case 'recurring':
				$conditions['Gift.frequency <>'] = 'onetime';
				$myParams = array(
					'start_date_day' => '01',
					'start_date_month' => date('m', strtotime('-1 month')),
					'start_date_year' => date('Y', strtotime('-1 month')),
					'end_date_day' => date('d'),
					'end_date_month' => date('m'),
					'end_date_year' => date('Y'),
				);
				$conditions = $this->GridFilter->dateRange($conditions, $myParams, 'Gift', 'created');
				break;
			case 'favorites':
			case 'starred':
				$conditions['Gift.id'] = $this->Session->read('favorites');
				break;
			case 'archived':
				$conditions['Gift.archived'] = '1';
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
				case 'fname':
					$conditions['Contact.fname LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'country':
					$countryId = $this->Country->lookup($params['keyword'], 'id', false);
					$addresses = $this->Address->find('all', array(
						'conditions' => array('country_id' => $countryId),
						'fields' => array('contact_id')
					));
					$conditions['Contact.id'] = Set::extract('/Address/contact_id', $addresses);
					break;
				case 'city':
					$cities = $this->City->find('all', array(
						'conditions' => array('name' => $params['keyword']),
						'fields' => array('id')
					));
					$addresses = $this->Address->find('all', array(
						'conditions' => array('city_id' => Set::extract('/City/id', $cities)),
						'fields' => array('contact_id')
					));
					$conditions['Contact.id'] = Set::extract('/Address/contact_id', $addresses);
					break;
				case 'name':
					$key = "CONCAT(Contact.fname,' ',Contact.lname)";
					$conditions[$key . ' LIKE'] = '%' . $params['keyword'] . '%';
					break;
			}
		}

		$conditions = $this->GridFilter->dateRange($conditions, $params, 'Gift', 'created');
		$this->Session->write('gifts_filter_conditions', $conditions);
		$this->paginate['Gift'] = array(
			'conditions' => $conditions,
			'recursive' => 4,
			'contain' => array(
				'Contact.Address.City',
				'Contact.Address.Country',
				'Contact.Address.Phone',
			),
			// @todo fetch number of successfull transaction (!) amounts (!) once transactions are implemented
			// @todo fetch number of successfull transactions once transactions are implemented
			'limit' => $params['my_limit'],
			'order' => $order
		);
		$supporters = $this->paginate('Gift');
		$this->set(compact('supporters', 'type', 'params'));
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