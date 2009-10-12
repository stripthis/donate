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
		$this->Office = $this->Appeal->Office;
		$this->Theme = $this->Appeal->Theme;
		$this->Template = $this->Appeal->Template;
		$this->Gateway = ClassRegistry::init('Gateway');
	}
/**
 * Admin Index
 * An admin manipulate an index of appeals: search, sort, paginate
 * @param $type string or array of options
 * @return void
 * @access public
 */
	function admin_index($type = 'all') {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');
		// data set is for the current country
		$conditions = array();
		switch ($type) {
			case 'office':
				$conditions['Appeal.office_id'] = $this->Session->read('Office.id');
				break;
		}
		// default search parameters
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

		// search was submitted
		if (!empty($params['keyword'])) {
			$params['keyword'] = trim($params['keyword']);

			switch ($params['search_type']) {
				case 'name':
					$conditions['Appeal.name LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'campaign_code':
					$conditions['Appeal.campaign_code LIKE'] = '%' . $params['keyword'] . '%';
					break;
				case 'author_email':
					$conditions['User.login LIKE'] = '%' . $params['keyword'] . '%';
					break;
				default:
					$conditions['or'] = array(
						'Appeal.name LIKE' => '%' . $params['keyword'] . '%',
						'Appeal.campaign_code LIKE' => '%' . $params['keyword'] . '%',
						'User.login LIKE' => '%' . $params['keyword'] . '%'
					);
					break;
			}
		}

		$this->paginate['Appeal'] = array(
			'conditions' => $conditions,
			'contain' => array('User(id, login)', 'CurrentTemplate(name)'),
			'order' => array('Appeal.name' => 'asc'),
			'limit' => $params['my_limit']
		);
		$appeals = $this->paginate($this->Appeal);
		$this->set(compact('appeals', 'type', 'params'));
	}
/**
 * Admin View
 * Admin view an appeal 
 *
 * @param string $id the appeal id
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		$appeal = $this->Appeal->find('first', array(
			'conditions' => array('Appeal.id' => $id),
			'contain' => array('Parent', 'User')
		));
		Assert::notEmpty($appeal, '404');
		Assert::true(User::allowed($this->name, $this->action, $appeal), '403');
		$this->set(compact('appeal'));
	}
/**
 * Admin add an appeal action - Redirect to admin edit
 * 
 * @return void
 * @access public
 */
	function admin_add() {
		Assert::true(User::allowed($this->name, $this->action), '403');
		$this->admin_edit();
	}
/**
 * Admin edit an appeal action
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
				'conditions' => array('Appeal.id' => $id)
			));
			Assert::notEmpty($appeal, '404');
			Assert::true(User::allowed($this->name, $this->action, $appeal), '403');
			$action = 'edit';
		}

		if ($action == 'add') {
			Assert::true(User::allowed($this->name, $this->action), '403');

			if (isset($this->params['named']['clone_id'])) {
				$appeal = $this->Appeal->find('first', array(
					'conditions' => array('Appeal.id' => $this->params['named']['clone_id']),
				));
				Assert::notEmpty($appeal, '404');
				unset($appeal['Appeal']['id']);
			}
		}

		$gatewayOptions = $this->Gateway->find('list_for_office', array(
			'order' => array('name' => 'asc')
		));
		$templateOptions = $this->Template->find('published_list');
		$processingOptions = $this->Gateway->find('processing_options');
		$themes = $this->Theme->find('all'); //@todo office_themes (v0.2)
		$statusOptions = $this->Appeal->enumOptions('status');

		$this->set(compact(
			'action', 'statusOptions', 'themes', 'gatewayOptions',
			'processingOptions', 'templateOptions'
		));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $appeal;
		}

		if ($action == 'add') {
			$this->data['Appeal']['user_id'] = User::get('id');
		}

		$this->data['Appeal']['office_id'] = $this->Session->read('Office.id');
		$this->Appeal->set($this->data['Appeal']);
		if (!$this->Appeal->save()) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		$msg = __('The Appeal was saved successfully.', true);
		if ($action == 'add') {
			$url = array('action' => 'edit', $this->Appeal->id);
			return $this->Message->add($msg, 'ok', true, $url);
		}
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
	}
/**
 * Admin delete an appeal action
 *
 * @param string $id the appeal id
 * @return void
 * @access public
 */
	function admin_delete($id = null, $undelete = false) {
		$appeal = $this->Appeal->find('first', array(
			'conditions' => compact('id')
		));
		Assert::notEmpty($appeal, '404');
		Assert::true(User::allowed($this->name, $this->action, $appeal), '403');

		$this->Appeal->del($id);
		$msg = __('The Appeal has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>