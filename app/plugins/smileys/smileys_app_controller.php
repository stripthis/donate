<?php
class SmileysAppController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function init() {
		$cacheKey = 'smileys';
		$smileys = Cache::read($cacheKey);
		if (true || !$smileys) {
			$Smiley = ClassRegistry::init('Smiley');
			$smileys = $Smiley->find('all', array(
				'order' => array('Smiley.code' => 'asc'),
				'contain' => false
			));
			$smileys = Set::combine($smileys, '/Smiley/code', '/Smiley/filename');
			Cache::write($cacheKey, $smileys, MONTH);
		}
		return compact('smileys');
	}
}
?>