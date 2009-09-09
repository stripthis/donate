<?php
class ExportsController extends AppController {
	var $uses = array();
	var $components = array('ForceDownload');
	var $sessKeyModel = 'export_model';
	var $sessKeyType = 'export_type';
	var $sessKeySelection = 'export_selection';
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		parent::beforeFilter();

		$this->Gift = ClassRegistry::init('Gift');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_gifts() {
		Assert::true($this->isPost() || $this->Session->read($this->sessKeyModel) == 'Gift', '404');

		$model = 'Gift';
		if (!isset($this->data[$model]['process'])) {
			$this->saveModel($model);
			$this->saveSelection($model);
			return;
		}
		$conditions = $this->Session->read('gifts_filter_conditions');
pr($this->data);
		$selection = $this->loadSelection();
		if (!empty($selection)) {
			$conditions['Gift.id'] = $selection;
		}

		$items = $this->$model->find('all', array(
			'conditions' => $conditions,
			'contain' => array('Contact'),
			'fields' => $this->data[$model]['fields']
		));

		if (!in_array('Contact.id', (array) $this->data[$model]['fields'])) {
			$items = Common::remove($items, '{n}.Contact.id');
		}

		$this->set(compact('items'));
		$this->RequestHandler->renderAs($this, $this->data[$model]['format']);
	}
/**
 * undocumented function
 *
 * @param string $model
 * @return void
 * @access public
 */
	function saveModel($model) {
		$this->Session->write($this->sessKeyModel, $model);
	}
/**
 * undocumented function
 *
 * @param string $model
 * @return void
 * @access public
 */
	function saveSelection($model) {
		if (!isset($this->data[$model])) {
			return false;
		}

		$selection = array();
		foreach ($this->data[$model] as $id => $value) {
			if ($value) {
				$selection[] = $id;
			}
		}
		$this->Session->write($this->sessKeySelection, $selection);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function loadModel() {
		return $this->Session->read($this->sessKeyModel);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function loadSelection() {
		return $this->Session->read($this->sessKeySelection);
	}
}
?>