<?php
class FiltersController extends FiltersAppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Filter = ClassRegistry::init('Filters.Filter');
	}
/**
 * undocumented function
 *
 * @return void
 */
	function admin_add() {
		$referer = $this->referer();
		$this->set(compact('referer'));

		if ($this->isGet()) {
			$params = $this->params['url'];
			$url = $params['link'];
			unset($params['ext'], $params['link'], $params['url']);
			$url = '/' . $url . '/?' . http_build_query($params);
			return $this->data['Filter']['url'] = $url;
		}

		$this->data['Filter']['user_id'] = User::get('id');

		$this->Filter->create($this->data);
		$this->Filter->save();

		$msg = __('Filter successfully saved!', true);
		$this->Message->add($msg, 'ok', true, $this->data['Filter']['referer']);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id) {
		$filter = $this->Filter->find('first', array(
			'conditions' => array('Filter.id' => $id),
			'contain' => false,
			'fields' => array('id', 'user_id')
		));
		Assert::notEmpty($filter, '404');
		Assert::true(AppModel::isOwn($filter, 'Filter'), '403');

		$this->Filter->del($id);
		$msg = __('Filter deleted.', true);
		$this->Message->add($msg, 'ok', true, $this->referer());
	}
}
?>