<?php
class ExportsController extends AppController {
	var $uses = array();
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

		$type = !empty($this->params['form']) ? key($this->params['form']) : false;
		$model = 'Gift';
		if (!isset($this->data[$model]['process'])) {
			$this->saveModel($model);
			$this->saveType($type);
			$this->saveSelection($model);
			return;
		}

		$conditions = array('Gift.office_id' => $this->Session->read('Office.id'));
		$type = $this->loadType($type);

		if (!$type) {
			$conditions['Gift.id'] = $this->loadSelection();
		} else {
			switch ($type) {
				case 'recurring':
					$conditions['Gift.frequency <>'] = 'onetime';
					break;
				case 'onetime':
					$conditions['Gift.frequency'] = 'onetime';
					break;
				case 'starred':
					$conditions['Gift.id'] = $this->Session->read('favorites');
					break;
			}
		}

		$items = $this->$model->find('all', array(
			'conditions' => $conditions,
			'contain' => array('Contact'),
			'fields' => $this->data[$model]['fields']
		));

		if (!in_array('Contact.id', $this->data[$model]['fields'])) {
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
	function saveType($type) {
		$this->Session->write($this->sessKeyType, $type);
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
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function loadType() {
		return $this->Session->read($this->sessKeyType);
	}
}
?>