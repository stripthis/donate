<?php
/**
 * Common Helper
 * Copyright (c)  GREENPEACE INTERNATIONAL 2009
 *
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Greenpeace International
 * @license     GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php  
 */
class CommonHelper extends Apphelper {
	var $helpers = array('Html', 'Form');
/**
 * undocumented function
 *
 * @param string $name 
 * @return void
 * @access public
 */
	function shortenName($name){
		$maxNameLength = 0;
		if (strlen($name) > $maxNameLength) {
	 		$name = explode(' ',$name);
			$length = count($name);
	 		for ($i = 0; $i< $length - 1; $i++) {
	 			$name[0] = $name[0][0].'.';
	 		}
	 		$name = implode(' ',$name);
		}
		return $name;
	}
/**
 * Gift Amount selection process - 
 * Help repopulate the 'other' text field 
 * @return the text to be put in the other textfield, null otherwise
 */
	function giftTextAmount(){
		if (isset($this->Form->params['data']['Gift'])) {
			if(isset($this->Form->params['data']['Gift']['amount']) && $this->Form->params['data']['Gift']['amount'] == $this->Form->params['data']['Gift']['amount_other']) {
				return $this->Form->params['data']['Gift']['amount_other'];
			}
		}
		return '';
	}
/**
 * Payment card selection repopulation
 * @return "checked='checked'" if the radio seems ok, null otherwise
 */
	function creditCardSelected($cc){
		if (isset($this->Form->params['data']['Payment']['card']['name'])) {
			if($this->Form->params['data']['Payment']['card']['name'] == $cc) {
				return 'checked=\'checked\'';
			}
		}
		return '';
	}
/**
 * undocumented function
 *
 * @param string $contact 
 * @return void
 * @access public
 */
	function contactName($contact) {
		return sprintf(
			'%s %s %s %s', 
			ucfirst($contact['Contact']['salutation']),
			$contact['Contact']['title'],
			$contact['Contact']['fname'],
			$contact['Contact']['lname']
		);
	}
/**
 * undocumented function
 */
	function getFoldClass($options){
		return (isset($options['leaf']) && isset($options['parent_id']) && $options['leaf']) ? 'leaf wrapper_toggle_'.$options['parent_id'] : '';
	}
/**
 * Get Months for gift date select options (credit card)
 * @return key value for month selection
 */
	function monthOptions(){
		$months = range('01', '12');
		foreach ($months as $key => $month) {
			$months[$key] = str_pad($month, 2, '0', STR_PAD_LEFT);
		}
		return array_combine($months, $months);
	}
}
?>