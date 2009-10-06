<?php
class Card extends AppModel {
	var $validate = array(
		'id' => array(
			'rule' => 'blank',
			'on' => 'update'
		),
		'type' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select a card.',
				'is_required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array("validateType"),
				'message' => 'This is an invalid type.',
			)
		),
		'cardholder_name' => array(
			'valid' => array(
				'rule' => array('custom', '/^[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+[\-,]?[ ]?[\p{Ll}\p{Lo}\p{Lt}\p{Lu} ]+$/'),
				'message' => 'Please provide a valid cardholder name.',
				'is_required' => false,
				'allowEmpty' => false,
			)
		),
		'number' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The card number is required!',
				'is_required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => 'cc',
				'message' => 'This is an invalid card number.',
				'is_required' => true
			)
		),
		'verification_code' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The card verification code is required!',
				'is_required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array("validateCardCode"),
				'message' => 'This is an invalid card verification code.',
				'is_required' => true
			)
		),
		'expire_date' => array(
			'required' => array(
				'rule' => array('validateExpireDate'),
				'message' => 'The expiration date must at least be one month in the future!',
				'is_required' => true,
				'last' => true
			)
		)
	);
/**
 * Validate card type from configuration
 * @param string $check 
 * @return void
 * @access public
 */
	function validateType($check) {
		return array_key_exists($check['type'], Configure::read('App.gift.cards'));
	}
/**
 * Validate card number based on the type (ex: visa)
 * @param $check
 * @return bool, true if validation success
 */	
	function validateCardNumber($check){
		if (isset($this->data["Card"]["type"])){
			$type = $this->data["Card"]["type"];
			$number = $check["number"];
			switch($type){
				case "visa":
					return(preg_match("/^4[0-9]{12}(?:[0-9]{3})?$/", $number));
				case "visa_electron":
					return(preg_match("/^4[0-9]{12}(?:[0-9]{3})?$/", $number));
				break;
				case "mastercard":
					return(preg_match("/^5[1-5][0-9]{14}$/", $number));
				break;
				case "amex":
					return(preg_match("/^3[47][0-9]{13}$/", $number));
				break;
				case "diners_club":
					return(preg_match("/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/", $number));
				break;
				case "discover":
					return(preg_match("/^6(?:011|5[0-9]{2})[0-9]{12}$/", $number));
				break;
				case "JCB":
					return(preg_match("/^(?:2131|1800|35\d{3})\d{11}$/", $number));
				break;
				default: return false;
			}
		}
		return false;
	}
/**
 * Validate card security/validation code (CVC, CVV, CID, etc.)
 * @param $check
 * @return bool, true if validation success
 */	
	function validateCardCode($check){
		if(isset($this->data["Card"]["type"])){
			$type = $this->data["Card"]["type"];
			$code = $check["verification_code"];
			switch($type){
				case "visa": // CVV2
				case "visa_electron":
				case "mastercard":
				case "diners_club":
				case "discover":
				case "JCB":
					return(preg_match("/^[0-9]{3}$/", $code));
				break;
				case "amex": // CID
					return(preg_match("/^[0-9]{4}$/", $code));
				break;
				default: return false;
			}
		}
		return false;
	}
/**
 * Return the default card
 */
	static function getTypes(){
		return Configure::read("App.gift.cards");
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		if (isset($this->data['Card']['expire_date'])) {
			$this->data['Card']['expire_month'] = $this->data['Card']['expire_date']['month'];
			$this->data['Card']['expire_year'] = $this->data['Card']['expire_date']['year'];
			unset($this->data['Card']['expire_date']);
		}
	}
/**
 * undocumented function
 *
 * @param string $value 
 * @return void
 * @access public
 */
	function validateExpireDate($val) {
		$month = $val['expire_date']['month'];
		$year = $val['expire_date']['year'];
		$time = strtotime('01-' . $month . '-' . $year);
		return $time >= time();
	}
}
?>