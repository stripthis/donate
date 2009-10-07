<?php
class SegmentsController extends SegmentsAppController {
	var $sessKeyModel = 'segment_model';
	var $sessKeySelection = 'segment_selection';

	function beforeFilter() {
		parent::beforeFilter();

		$this->Segment = ClassRegistry::init('Segments.Segment');
	}
/**
 * undocumented function
 *
 * @return void
 */
	function admin_add($process = 0) {
		if (!$this->isPost()) {
			$msg = 'There was a problem saving the segment.';
			return $this->Message->add($msg, 'error', true, $this->referer());
		}

		$referer = $this->referer();
		$this->set(compact('referer'));
		if (!$process) {
			$model = key($this->data);
			$this->data['Segment']['model'] = $model;
			return $this->data['Segment']['items'] = implode(',', $this->selection($model));
		}

		$this->data['Segment']['user_id'] = User::get('id');
		$this->Segment->create($this->data);
		$this->Segment->save();

		$msg = __('Segment successfully saved!', true);
		$this->Message->add($msg, 'ok', true, $this->data['Segment']['referer']);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_view($id = false) {
		$contain = array();
		$models = Configure::read('Segments.models');
		foreach ($models as $model) {
			$contain[] = 'SegmentItem.' . $model;
		}

		$containments = Configure::read('Segments.contain');
		foreach ($containments as $key => $containment) {
			$contain[] = 'SegmentItem.' . $containment;
		}

		$segment = $this->Segment->find('first', array(
			'conditions' => array('Segment.id' => $id),
			'contain' => $contain
		));
		Assert::notEmpty($segment, '404');

		$this->set(compact('segment'));
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id) {
		$segment = $this->Segment->find('first', array(
			'conditions' => array('Segment.id' => $id),
			'contain' => false,
			'fields' => array('id', 'user_id')
		));
		Assert::notEmpty($segment, '404');
		Assert::true(AppModel::isOwn($segment, 'Segment'), '403');

		$this->Segment->del($id);
		$this->Message->add('Segment deleted.', 'ok', true, $this->referer());
	}
/**
 * undocumented function
 *
 * @param string $model
 * @return void
 * @access public
 */
	function selection($model) {
		if (!isset($this->data[$model])) {
			return false;
		}

		$selection = array();
		foreach ($this->data[$model] as $id => $value) {
			if ($value) {
				$selection[] = $id;
			}
		}
		return $selection;
	}
}
?>