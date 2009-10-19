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
	 		for ($i = 0; $i < $length - 1; $i++) {
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
			if (
				isset($this->Form->params['data']['Gift']['amount']) &&
				$this->Form->params['data']['Gift']['amount'] == $this->Form->params['data']['Gift']['amount_other']
			) {
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
		return (
			isset($options['leaf']) && isset($options['parent_id']) &&
			$options['leaf'])
			? 'leaf wrapper_toggle_' . $options['parent_id'] : '';
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
/**
 * Return a tooltip
 * @param $tip string
 * @return string html formated tooltip
 */
	function tooltip($tip=null,$options=array()){
		$msg = '';
		if (!empty($tip)) {
			$user = User::get('User');
			if (isset($user['tooltips']) && $user['tooltips']) {
				if (isset($options['class'])) {
					$options['class'] .= " tooltip with_img information";
				} else {
					$options['class'] =  "tooltip with_img information";
				}
				$msg =  '<span class="'.$options['class'].'" title="'.$tip.'">'.$tip.'</span>';
			}
		}
		return $msg;
	}
/**
 * Get and group permissions
 * @param 	$role (optional)
 * @return  arrray $item[$controller][$action]
 */
	static function getPermissions($role=null){
		$permissions = Configure::read('App.permissions.options');
		$controller = '';
		$action = '';
		$items = array();

		foreach ($permissions as $perm) {
			$perm = trim($perm);
			$permData = explode(':', $perm);
			$controller = $permData[0];
			$action = $permData[1];

			if (!isset($role['Role']['permissions'])) {
				$allowed = '0';
			} else {
				$allowed = Common::requestAllowed($controller, $action, $role['Role']['permissions'], true);
			}
			$items[$controller][$action] = $allowed;
		}
		return $items;
	}
/**
 * undocumented function
 *
 * @param string $gift 
 * @return void
 * @access public
 */
	function giftStatus($gift) {
		if (!isset($gift['Gift'])) {
			$gift = array('Gift' => $gift);
		}

		$status = 'tick';
		if (!$gift['Gift']['complete']) {
			$status = 'error';
		} elseif (isset($gift['Gift']['status']) && !empty($gift['Gift']['status'])) {
			$status = $gift['Gift']['status'];
		}
		return $status;
	}
/** 
 * Format a help message
 * @param $help array{content, type, class}
 * @return string
 * @todo hide + never show again (textbox)
 */
	function help($msg, $options=null){
		$default_options = array('class'=>'message information');
		$options = am($default_options,$options);
		if (isset($msg)) {
			return '<div class="'.$options['class'].'">'.$msg.'</div>';
		}
	}
/**
 * Shortcut for datepicker
 * @param string context aka input(s) type {'text','select'}
 * @param options array, return or echo
 */
	function datepicker($type='text',$options=null){
		$options = am(array('return'=>false),$options);
		$result = '';
		if ($type == 'select') {
			$result .= '<input class="datepicker select_a" type="hidden"/>';
		}
		if ($options['return']) {
			return $result;
		} else {
			echo $result;
		}
	}
/**
 * undocumented function
 *
 * @param string $date 
 * @return void
 * @access public
 */
	function date($date) {
		if (!is_int($date)) {
			$date = strtotime($date);
		}
		$format = 'd. M y @ H:i';
		if (date('Y', $date) == date('Y')) {
			$format = 'd. M @ H:i';
		}
		return date($format, $date);
	}
/**
 * undocumented function
 *
 * @param string $email 
 * @return void
 * @access public
 */
	function gravatar($email, $size = '50') {
		$imgUrl = 'http://www.gravatar.com/avatar.php?gravatar_id=';
		$imgUrl .= md5(low($email)) . '&size=' . $size . '&rating=R&d=identicon';
		$img = $this->Html->image($imgUrl, compact('width', 'height'));
		return $this->Html->link($img, 'http://en.gravatar.com/site/signup', array('class' => 'gravatar'), false, false);
	}
/**
 * undocumented function
 *
 * @param string $params 
 * @return void
 * @access public
 */
	function urlQuery($params, $prependUrl = true) {
		$url = $params['url']['url'];
		unset($params['url']['ext'], $params['url']['url']);
		$query = http_build_query($params['url']);
		if ($prependUrl) {
 			return $url . '&' . $query;
		}
		return $query;
	}
}
?>