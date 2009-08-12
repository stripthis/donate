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
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array("validateType"),
				'message' => 'This is an invalid type.',
			)
		),
		'number' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The card number is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array("validateCardNumber"),
				'message' => 'This is an invalid card number.',
				'required' => true
			)
		),
		'verification_code' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'The card verification code is required!',
				'required' => true,
				'last' => true
			),
			'valid' => array(
				'rule' => array("validateCardCode"),
				'message' => 'This is an invalid card verification code.',
				'required' => true
			)
		),
		'expire_month' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'last' => true
			)
		),
		'expire_year' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'last' => true
			)
		)
	);
/**
 * undocumented function
 *
 * @param string $check 
 * @return void
 * @access public
 */
	function validateType($check) {
		return array_key_exists($check['type'], Configure::read('App.card_types'));
	}
/**
 * Validate card number based on the type (ex: visa)
 * @param $check
 * @return bool, true if validation success
 */	
	function validateCardNumber($check){
		if(isset($this->data["Card"]["type"])){
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
}
?>