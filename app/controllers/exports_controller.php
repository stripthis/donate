<?php
class ExportsController extends AppController {
	var $components = array('ForceDownload');
	var $helpers = array('Csv');
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
		$this->Transaction = ClassRegistry::init('Transaction');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_gifts() {
		$this->_process('Gift', array('Contact', 'Currency'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_transactions() {
		$this->_process('Transaction', array('Gift', 'Currency'));
	}
/**
 * undocumented function
 *
 * @param string $model 
 * @param string $contain 
 * @return void
 * @access public
 */
	function _process($model, $contain = array()) {
		Assert::true(User::allowed($this->name, $this->action), '403');
		Assert::true($this->isPost() || $this->Session->read($this->sessKeyModel) == $model, '404');

		if (isset($this->data[$model]) && !isset($this->data[$model]['process'])) {
			$this->saveModel($model);
			return $this->saveSelection($model);
		}

		$plural = low(Inflector::pluralize($model));
		$conditions = $this->Session->read($plural . '_filter_conditions');

		$selection = $this->loadSelection();
		if (!empty($selection)) {
			$conditions[$model . '.id'] = $selection;
		}

		// remove gift id from csv fields, although cake fetched it to do joins
		$addedGiftId = false;
		if (!in_array($model . '.id', (array) $this->data[$model]['fields'])) {
			$addedGiftId = true;
			$this->data[$model]['fields'][] = $model . '.id';
		}

		$items = $this->$model->find('all', array(
			'conditions' => $conditions,
			'contain' => $contain,
			'fields' => am($this->data[$model]['fields'], array('Currency.iso_code'))
		));

		// remove the gift id from fields list now if needed
		if ($addedGiftId) {
			$key = array_search($model . '.id', $this->data[$model]['fields']);
			unset($this->data[$model]['fields'][$key]);
		}

		if ($this->data[$model]['softdelete']) {
			$this->$model->softdelete($items);
		}

		$items = $this->filterFields($model, $items, $contain);

		foreach ($items as $i => $item) {
			$items[$i][$model]['amount'] .= ' ' . $items[$i]['Currency']['iso_code'];
			unset($items[$i]['Currency']);
		}

		if (isset($this->data[$model]['download']) && $this->data[$model]['download']) {
			$name = $plural . '_export_' . date('Y_m_d_H_i');
			$path = '/admin/exports/' . $plural . '.' . $this->data[$model]['format'];
			$this->ForceDownload->forceDownload($path, $name);
		}

		$Export = ClassRegistry::init('Export');
		$Export->create(array(
			'user_id' => User::get('id'),
			'nb_exported' => count($items),
			'model' => $model
		));
		$Export->save();

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
/**
 * undocumented function
 *
 * @param string $model 
 * @param string $items 
 * @param string $fields 
 * @return void
 * @access public
 */
	function filterFields($model, $items, $contain) {
		$fields = array($model . '.id');
		foreach ($contain as $contained) {
			$fields[] = $contained . '.id';
		}

		foreach ($fields as $field) {
			if (!in_array($field, (array) $this->data[$model]['fields'])) {
				$items = Common::remove($items, '{n}.' . $field);
			}
		}
		return $items;
	}
}
?>