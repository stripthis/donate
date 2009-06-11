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
	 		$name = explode(" ",$name);
			$length = count($name);
	 		for ($i = 0; $i< $length - 1; $i++) {
	 			$name[0] = $name[0][0].".";
	 		}
	 		$name = implode(" ",$name);
		}
		return $name;
	}
/**
 * undocumented function
 *
 * @param string $score 
 * @return void
 * @access public
 */
	function loadingColor($score){
		if ($score <= 10) return 'red';
		if ($score <= 40) return 'orange';
		if ($score <= 60) return 'yellow';
		return 'green';
	}
/**
 * Get the url of a leader's page (cf. P2 mirroring) 
 * @param $leader
 * @return $url string
 */
	function getLeaderUrl($leader){
		$url = "";
		if(isset($leader["Leader"]) && !empty($leader["Leader"])) {
			if(Configure::read("App.usingMirror")){
				$url = Configure::read('App.mirrorDomain');
				$url.= preg_replace('/(\w\. )/','',low($leader['Leader']['name']));
				$url.= '-'.str_replace(' ','-',low($leader['Leader']['company']));
				$url = str_replace(' ','-',$url);
				if($leader['Leader']['company'] == "Dell") {
					$url = str_replace('-dell-dell','-dell',$url);
				}
			} else {
				$url = "/leaders/view/".$leader['Leader']['id'];
			}
		}
		return $url;
	}
}
?>