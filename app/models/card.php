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
		'expire_month' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'is_required' => true,
				'last' => true
			)
		),
		'expire_year' => array(
			'required' => array(
				'rule' => 'notEmpty',
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
		return array_key_exists($check['type'], Configure::read('App.cards'));
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
		return Configure::read("App.cards");
	}
/**
 * Get Months for gift date select options (credit card)
 * @return key value for month selection
 */
	static function getMonthOptions(){
		$months = array(
			"01" => "01", "02" => "02", "03" => "03",
			"04" => "04",	"05" => "05",	"06" => "06",
			"07" => "07",	"08" => "08",	"09" => "09",
			"10" => "10",	"11" => "11",	"12" => "12",
		);
		return $months;
	}
/**
 * Get Years for gift date select options (credit card)
 * @return key value for year selection
 */
	static function getYearOptions(){
		$years = array();
		$y = (date("Y", strtotime("now")));
		for ($i=$y;$i<=$y+10;$i++) {
			$years[$i] = $i;
		}
		return $years;
	}
}
?>