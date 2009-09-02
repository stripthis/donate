<?php
class StatesController extends AppController {
/**
 * undocumented function
 *
 * @param unknown $page
 * @return void
 * @access public
 */
	function by_country($countryId = null) {
		$cachekey = 'states_' . $countryId;
		$states = Cache::read($cachekey);

		if (!$states) {
			$states = $this->State->find('all', array(
				'conditions' => array('State.country_id' => $countryId),
				'order' => array('State.name' => 'asc'),
				'fields' => array('id', 'name')
			));
			$emptyState = array('State' => array('id' => '', 'name' => '--'));
			array_unshift($states, $emptyState);
			Cache::write($cachekey, $states);
		}
		$this->set(compact('states'));
	}
}
?>