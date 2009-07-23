<?php
/**
 * Component to use Worldpay interface
 *
 * @package 	app
 * @subpackage 	app.controllers.components
 * @author 		Nicolas Herve <nherve@gmail.com>
 * @copyright 	Enova-technologies
 */
class WorldpayComponent extends Object {
	const HOST_TEST = 'select-test.worldpay.com';
	const HOST_PROD = 'select.worldpay.com';
	
	/**
	 * The installation ID
	 *
	 * @var string
	 */
	static $_instId = '210097';
	
	/**
	 * A COF reference to identify the purchase
	 *
	 * @var string
	 */
	var $_cartId;
	
	/**
	 * The total cost for the item
	 *
	 * @var float
	 */
	var $_amount;
	
	/**
	 * The currency code
	 *
	 * @var string
	 */
	var $_currency;
	var $_isTest;
	var $_options = array();
/**
 * Called before Controller::beforeFilter()
 * 
 * @param Controller $controller
 */
	function initialize(&$controller) {
		$this->controller = & $controller;
	}
/**
 * Called after Controller::beforeFilter()
 *
 * @param Controller $controller
 */
	function startup(&$controller) {
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _getURL() {
		return 'https://' . $this->_getHost() . '/wcc/purchase';
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _getHost() {
		if (!isset($this->_isTest)) {
			if (Configure::read('debug') > 0) {
				$this->_isTest = true;
				return self::HOST_TEST;
			}
			$this->_isTest = false;
			return self::HOST_PROD;
		}
		if ($this->_isTest) {
			return self::HOST_TEST;
		}
		return self::HOST_PROD;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function setTestMode() {
		$this->_isTest = true;
	}
/**
 * undocumented function
 *
 * @param string $amount 
 * @return void
 * @access public
 */
	function setAmount($amount) {
		$this->_amount = $amount;
	}
/**
 * undocumented function
 *
 * @param string $currency 
 * @return void
 * @access public
 */
	function setCurrency($currency) {
		$this->_currency = $currency;
	}
/**
 * undocumented function
 *
 * @param string $cartId 
 * @return void
 * @access public
 */
	function setCartId($cartId) {
		$this->_cartId = $cartId;
	}
/**
 * undocumented function
 *
 * @param string $description 
 * @return void
 * @access public
 */
	function setDescription($description) {
		$this->_options['description'] = $description;
	}
/**
 * undocumented function
 *
 * @param string $name 
 * @return void
 * @access public
 */
	function setUserName($name) {
		$this->_options['user']['name'] = $name;
	}
	
	function setUserAddress($address) {
		$this->_options['user']['address'] = $address;
	}
	
	function setUserEmail($email) {
		$this->_options['user']['email'] = $email;
	}
	
	function setUserPostCode($postcode) {
		$this->_options['user']['postcode'] = $postcode;
	}
	
	function setUserCountry($country) {
		$this->_options['user']['country'] = $country;
	}
	
	function setUserPhone($phone) {
		$this->_options['user']['tel'] = $phone;
	}
	
	function setUserFax($fax) {
		$this->_options['user']['fax'] = $fax;
	}
	
	function setCustomField($fieldName, $fieldValue) {
		$this->_options['custom']['M_'.$fieldName] = $fieldValue;
	}
	
	function setWithDelivery($withDelivery=true) {
		if ($withDelivery){
			$this->_options['withDelivery'] = 1;
		}
	}
	
	function getForm($formId='formWorldPay') {
		
		$html = '<form action="'.$this->_getURL().'" method="post" id="'.$formId.'" style="display:none;">';
		// Depending on the test mode
		if ($this->_isTest) {
			$html .= '<input type="hidden" name="testMode" value="100" />';
		}
		// Mandatory fields
		$html .= '<input type="hidden" name="instId" value="'.self::$_instId.'" />';
		$html .= '<input type="hidden" name="cartId" value="'.$this->_cartId.'" />';
		$html .= '<input type="hidden" name="amount" value="'.$this->_amount.'" />';
		$html .= '<input type="hidden" name="currency" value="'.$this->_currency.'" />';
		// Fixed fields
		$html .= '<input type="hidden" name="lang" value="en" />';
		//$html .= '<input type="hidden" name="fixContact" />';
		//$html .= '<input type="hidden" name="hideContact" />';
		// Custom fields
		if (isset($this->_options['custom'])) {
			foreach ($this->_options['custom'] as $fieldName => $fieldValue) {
				$html .= '<input type="hidden" name="'.$fieldName.'" value="'.$fieldValue.'" />';
			}
		}
		// Optional fields
		if (isset($this->_options['description'])) {
			$html .= '<input type="hidden" name="desc" value="'.$this->_options['description'].'" />';
		}
		if (isset($this->_options['user']['name'])) {
			$html .= '<input type="hidden" name="name" value="'.$this->_options['user']['name'].'" />';
		}
		if (isset($this->_options['user']['email'])) {
			$html .= '<input type="hidden" name="email" value="'.$this->_options['user']['email'].'" />';
		}
		if (isset($this->_options['user']['address'])) {
			$html .= '<input type="hidden" name="address" value="'.$this->_options['user']['address'].'" />';
		}
		if (isset($this->_options['user']['postcode'])) {
			$html .= '<input type="hidden" name="postcode" value="'.$this->_options['user']['postcode'].'" />';
		}
		if (isset($this->_options['user']['country'])) {
			$html .= '<input type="hidden" name="country" value="'.$this->_options['user']['country'].'" />';
		}
		if (isset($this->_options['user']['tel'])) {
			$html .= '<input type="hidden" name="tel" value="'.$this->_options['user']['tel'].'" />';
		}
		if (isset($this->_options['user']['fax'])) {
			$html .= '<input type="hidden" name="fax" value="'.$this->_options['user']['fax'].'" />';
		}
		$html .= '</form>';

		// Javascript for auto submission
		$html .= '<script type="text/javascript">'."\n";
		$html .= '//<![CDATA['."\n";
		$html .= '$("'.$formId.'").submit();'."\n";
		$html .= '//]]>'."\n";
		$html .= '</script>'."\n";

		return $html;
	}
}
?>