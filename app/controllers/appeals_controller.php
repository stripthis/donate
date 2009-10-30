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
		$this->Template = ClassRegistry::init('Template');
		$this->Gateway = ClassRegistry::init('Gateway');
	}
/**
 * Admin Index
 * An admin manipulate an index of appeals: search, sort, paginate
 * @param $type string or array of options
 * @return void
 * @access public
 */
	function admin_index() {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$params = $this->_parseGridParams();
		$conditions = $this->_conditions($params);

		$this->paginate['Appeal'] = array(
			'recursive' => 1,
			'conditions' => $conditions,
			'contain' => array(
				'User(id, login)',
				'Template(name)'
			),
			'order' => array('Appeal.name' => 'asc'),
			'limit' => $params['my_limit']
		);
		$appeals = $this->paginate($this->Appeal);

		$this->set(compact('appeals', 'params'));
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
				'conditions' => array('Appeal.id' => $id),
				'contain' => array('Theme(id)')
			));
			Assert::notEmpty($appeal, '404');
			Assert::true(User::allowed($this->name, $this->action, $appeal), '403');

			$action = 'edit';
		}

		if ($action == 'add' && isset($this->params['named']['clone_id'])) {
			$appeal = $this->Appeal->find('first', array(
				'conditions' => array(
					'Appeal.id' => $this->params['named']['clone_id']
				)
			));
			Assert::notEmpty($appeal, '404');
			unset($appeal['Appeal']['id']);
		}

		$gatewayOptions = $this->Gateway->find('list_for_office');
		$templateOptions = $this->Template->find('published_list');
		$processingOptions = $this->Gateway->find('processing_options');
		$themes = $this->Theme->find('all');

		$this->set(compact(
			'action', 'themes', 'gatewayOptions',
			'processingOptions', 'templateOptions', 'appeal'
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
/**
 * undocumented function
 */
	function admin_redirect(){
		$url = array(
			'controller' => 'gifts', 
			'action' => 'add' , 
			'admin' => 0
		);
		if(isset($this->params['data']['Appeal']['id'])) {
			$url[] =	'appeal_id:' . $this->params['data']['Appeal']['id'];
		}
		$this->redirect($url);
		exit;
	}
/**
 * undocumented function
 *
 * @param string $params 
 * @return void
 * @access public
 */
	function _conditions($params) {
		$conditions = array(
			'Appeal.office_id' => $this->Session->read('Office.id')
		);

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

		$conditions = $this->Appeal->dateRange($conditions, $params, 'created');
		return $conditions;
	}
}
?>