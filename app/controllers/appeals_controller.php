<?php
class AppealsController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();
		$this->Country = $this->Appeal->Country;
	}
/**
 * index action
 *
 * @return void
 * @access public
 */
	function admin_index() {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');
		$conditions = array(
			'Appeal.office_id' => $this->Session->read('Office.id')
		);

		$keyword = isset($this->params['url']['keyword'])
					? $this->params['url']['keyword']
					: '';
		$searchType = isset($this->params['url']['search_type'])
					? $this->params['url']['search_type']
					: 'all';
		$limit = isset($this->params['url']['my_limit'])
					? $this->params['url']['my_limit']
					: 20;
		$customLimit = isset($this->params['url']['custom_limit'])
					? $this->params['url']['custom_limit']
					: false;
		if (is_numeric($customLimit)) {
			if ($customLimit > 75) {
				$customLimit = 75;
			}
			$limit = $customLimit;
		}

		// search was submitted
		if (!empty($keyword)) {
			$keyword = trim($keyword);

			switch ($searchType) {
				case 'name':
					$conditions['Appeal.name LIKE'] = '%' . $keyword . '%';
					break;
				case 'campaign_code':
					$conditions['Appeal.campaign_code LIKE'] = '%' . $keyword . '%';
					break;
				case 'country':
					$conditions['Country.name LIKE'] = '%' . $keyword . '%';
					break;
				case 'author_email':
					$conditions['User.login LIKE'] = '%' . $keyword . '%';
					break;
				default:
					$conditions['or'] = array(
						'Appeal.name LIKE' => '%' . $keyword . '%',
						'Appeal.campaign_code LIKE' => '%' . $keyword . '%',
						'Country.name LIKE' => '%' . $keyword . '%',
						'User.login LIKE' => '%' . $keyword . '%'
					);
					break;
			}
		}

		$this->paginate['Appeal'] = array(
			'conditions' => $conditions,
			'contain' => array('User(id, login)', 'Country(name)'),
			'order' => array('Appeal.name' => 'asc')
		);
		$appeals = $this->paginate($this->Appeal);
		$this->set(compact(
			'appeals', 'type', 'searchType', 'keyword', 'limit', 'customLimit'
		));
	}
/**
 * view action
 *
 * @param string $id the appeal id
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		Assert::true(User::allowed($this->name, $this->action, $appeal), '403');

		$appeal = $this->Appeal->find('first', array(
			'conditions' => array('Appeal.id' => $id),
			'contain' => array('Parent', 'User', 'Country')
		));
		Assert::notEmpty($appeal, '404');
		$this->set(compact('appeal'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_add() {
		Assert::true(User::allowed($this->name, $this->action), '403');
		$this->admin_edit();
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_edit($id = null) {
		$appeal = $this->Appeal->create();
		$action = 'add';
		if ($this->action == 'admin_edit') {
			$appeal = $this->Appeal->find('first', array(
				'conditions' => array('Appeal.id' => $id),
				'contain' => false,
			));
			Assert::notEmpty($appeal, '404');
			Assert::true(User::allowed($this->name, $this->action, $appeal), '403');
			$action = 'edit';
		}

		$countryOptions = $this->Country->find('list');
		$this->set(compact('action', 'countryOptions'));
		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $appeal;
		}

		if ($action == 'add') {
			$this->data['Appeal']['user_id'] = User::get('id');
		}

		$this->data['Appeal']['office_id'] = $this->Session->read('Office.id');
		$this->Appeal->set($this->data['Appeal']);
		$result = $this->Appeal->save();
		if ($this->Appeal->validationErrors) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}
		Assert::notEmpty($result);

		$msg = __('Appeal was saved successfully.', true);
		if ($action == 'add') {
			$url = array('action' => 'admin_edit', $this->Appeal->id);
			return $this->Message->add($msg, 'ok', true, $url);
		}
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
/**
 * delete action
 *
 * @param string $id the appeal id
 * @return void
 * @access public
 */
	function admin_delete($id = null, $undelete = false) {
		$appeal = $this->Appeal->find('first', array(
			'conditions' => compact('id'),
			'contain' => false
		));
		Assert::notEmpty($appeal, '404');
		Assert::true(User::allowed($this->name, $this->action, $appeal), '403');

		$this->Appeal->del($id);
		$msg = __('The Appeal has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>