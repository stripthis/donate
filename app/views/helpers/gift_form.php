<?php
class GiftFormHelper extends AppHelper {
/**
 * undocumented function
 *
 * @param string $model 
 * @param string $field 
 * @param string $default 
 * @param string $data 
 * @return void
 * @access public
 */
	function value($model, $field, $default, $data) {
		$result = $default;

		$this->Cookie = Common::getComponent('Cookie');
        $cookieValue = $this->Cookie->read($model . '.' . $field);
		if (!empty($cookieValue)) {
			$result = $cookieValue;
		}

		$this->Session = Common::getComponent('Session');
        $sessValue = $this->Session->read($model . '.' . $field);
		if (!empty($sessValue)) {
			$result = $sessValue;
		}

		if (isset($form->data[$model][$field])) {
			$result = $form->data[$model][$field];
		}
		return $result;
	}
}
?>