<?php
class WidgetStatesController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_save() {
		Assert::true($this->isPost(), '404');

		$this->data = array('WidgetState' => $this->params['form']);

		$userId = User::get('id');
		$widgetState = $this->WidgetState->find('first', array(
			'conditions' => array('user_id' => $userId)
		));
		$this->data['WidgetState']['user_id'] = $userId;
		if (empty($widgetState)) {
			$this->WidgetState->create($this->data);
		} else {
			$this->data['WidgetState']['id'] = $widgetState['WidgetState']['id'];
			$this->WidgetState->set($this->data);
		}
		$this->WidgetState->save();

		$this->Message->add(false, 'ok');
	}
}
?>