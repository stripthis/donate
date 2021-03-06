<?php
class SupportersController extends AppController {
	var $helpers = array('Fpdf', 'GiftForm');
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
		$this->Contact = ClassRegistry::init('Contact');
		$this->Gift = ClassRegistry::init('Gift');
		$this->Frequency = $this->Gift->Frequency;
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

		$giftConditions = array(
			'Gift.office_id' => $this->Session->read('Office.id'),
		);

		$onetime = $this->Frequency->lookup('onetime', 'id', false);
		switch ($type) {
			case 'signups':
				// doesn't have gift
				break;
			case 'oneoff':
				$giftConditions['Gift.frequency_id'] = $onetime;
				break;
			case 'recurring':
				$giftConditions['Gift.frequency_id <>'] = $onetime;
				$myParams = array(
					'start_date_day' => '01',
					'start_date_month' => date('m', strtotime('-1 month')),
					'start_date_year' => date('Y', strtotime('-1 month')),
					'end_date_day' => date('d'),
					'end_date_month' => date('m'),
					'end_date_year' => date('Y'),
				);
				$giftConditions = $this->Gift->dateRange($giftConditions, $myParams, 'created');
				break;
			case 'favorites':
			case 'starred':
				$conditions['Contact.id'] = $this->Session->read('favorites');
				break;
		}

		if (!empty($giftConditions)) {
			$gifts = $this->Gift->find('all', array(
				'conditions' => $giftConditions,
				'contain' => false,
				'fields' => array('contact_id')
			));
			$ids = Set::extract('/Gift/contact_id', $gifts);
			if (isset($conditions['Contact.id'])) {
				$conditions['Contact.id'] = array_intersect($conditions['Contact.id'], $ids);
			} else {
				$conditions['Contact.id'] = $ids;
			}
		}

		$params = $this->_parseGridParams();
		$conditions = $this->_conditions($params, $conditions);
		$this->Session->write('gifts_filter_conditions', $conditions);
		$this->paginate['Contact'] = array(
			'conditions' => $conditions,
			'recursive' => 4,
			'contain' => array(
				'Address.City',
				'Address.Country',
				'Address.Phone',
			),
			// @todo fetch number of successfull transaction (!) amounts (!) once transactions are implemented
			// @todo fetch number of successfull transactions once transactions are implemented
			'limit' => $params['my_limit'],
			'order' => array("CONCAT(Contact.fname,' ',Contact.lname)" => 'asc')
		);
		$supporters = $this->paginate('Contact');

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
		Assert::true(false, '404');
		$user = $this->User->find('first', $id);
		$this->User->delete($id);
		$this->Silverpop->UserOptOut($user);
		$msg = __('Successfully deleted!', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		$contact = $this->Contact->find('first', array(
			'conditions' => array('Contact.id' => $id),
			'contain' => array(
				'Gift.Frequency',
				'Address.Phone',
				'Address.Country(id, name)',
				'Address.State(id, name)',
				'Address.City(id, name)',
			)
		));
		$this->set(compact('contact'));
	}
/**
 * undocumented function
 *
 * @param string $params 
 * @return void
 * @access public
 */
	function _conditions($params, $conditions) {
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
					$ids = Set::extract('/Address/contact_id', $addresses);
					if (isset($conditions['Contact.id'])) {
						$conditions['Contact.id'] = array_intersect($conditions['Contact.id'], $ids);
					} else {
						$conditions['Contact.id'] = $ids;
					}
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

					$ids = Set::extract('/Address/contact_id', $addresses);
					if (isset($conditions['Contact.id'])) {
						$conditions['Contact.id'] = array_intersect($conditions['Contact.id'], $ids);
					} else {
						$conditions['Contact.id'] = $ids;
					}
					break;
				case 'name':
					$key = "CONCAT(Contact.fname,' ',Contact.lname)";
					$conditions[$key . ' LIKE'] = '%' . $params['keyword'] . '%';
					break;
			}
		}

		$conditions = $this->Contact->dateRange($conditions, $params, 'created');
		return $conditions;
	}
}
?>