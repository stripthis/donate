<?php
class TemplatesController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();
		$this->Gateway = ClassRegistry::init('Gateway');
	}
/**
 * Admin Index
 * An admin manipulate an index of templates: search, sort, paginate
 * @param $type string or array of options
 * @return void
 * @access public
 */
	function admin_index($type = 'all') {
		Assert::true(User::allowed($this->name, 'admin_view'), '403');

		$this->paginate['Template'] = array(
			'order' => array('Template.name' => 'asc'),
			'limit' => 10
		);
		$templates = $this->paginate($this->Template);
		$this->set(compact('templates'));
	}
/**
 * Admin View
 * Admin view an template 
 *
 * @param string $id the template id
 * @return void
 * @access public
 */
	function admin_view($id = null) {
		$template = $this->Template->find('first', array(
			'conditions' => array('Template.id' => $id)
		));
		Assert::notEmpty($template, '404');
		Assert::true(User::allowed($this->name, $this->action, $template), '403');
		$this->set(compact('template'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_publish($id = null) {
		Assert::true(User::allowed($this->name, $this->action), '403');
		$this->Template->set(array(
			'id' => $id,
			'published' => '1'
		));
		$this->Template->save(null, false);

		$msg = __('The template was published successfully!', true);
		$this->Message->add($msg, 'ok', true, $this->referer());
	}
/**
 * Admin add an template action - Redirect to admin edit
 * 
 * @return void
 * @access public
 */
	function admin_add() {
		Assert::true(User::allowed($this->name, $this->action), '403');

		$templateOptions = $this->Template->find('list', array(
			'order' => array('name' => 'asc')
		));
		$this->set(compact('templateOptions'));
		if ($this->isGet()) {
			return;
		}

		$this->data['Template']['user_id'] = User::get('id');
		$this->Template->create($this->data);
		if (!$this->Template->save()) {
			$msg = 'There was a problem with the form!';
			return $this->Message->add($msg, 'error');
		}

		$url = array('action' => 'edit', $this->Template->id);
		$msg = __('The template was saved successfully! Now add the template code!', true);
		$this->Message->add($msg, 'ok', true, $url);
	}
/**
 * Admin edit an template action
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_edit($id = null) {
		$template = $this->Template->find('first', array(
			'conditions' => array('Template.id' => $id)
		));
		Assert::notEmpty($template, '404');
		Assert::true(User::allowed($this->name, $this->action, $template), '403');

		$this->set(compact('action', 'template'));

		$this->action = 'admin_edit';
		if ($this->isGet()) {
			return $this->data = $template;
		}

		$this->Template->set($this->data);
		if (!$this->Template->save()) {
			return $this->Message->add(__('Please fill out all fields', true), 'error');
		}

		$msg = __('The Template was saved successfully.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
	}
/**
 * Admin delete an template action
 *
 * @param string $id the template id
 * @return void
 * @access public
 */
	function admin_delete($id = null, $undelete = false) {
		$template = $this->Template->find('first', array(
			'conditions' => compact('id')
		));
		Assert::notEmpty($template, '404');
		Assert::true(User::allowed($this->name, $this->action, $template), '403');

		$this->Template->del($id);
		$msg = __('The Template has been deleted.', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'admin_index'));
	}
}
?>