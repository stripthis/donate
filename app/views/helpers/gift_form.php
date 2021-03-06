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

		if (isset($data[$model][$field])) {
			$result = $data[$model][$field];
		}
		return $result;
	}
/**
 * undocumented function
 */
	function hint($txt){
		return '<span class="tooltip with_img information" title="' . $txt . '">&nbsp;</span>';
	}
/**
 * undocumented function
 */
	static function checked(){
		return 'checked="checked"';
	}
/**
 * undocumented function
 */
	static function required(){
		return '<strong class="required">*</strong>';
	}
}
?>