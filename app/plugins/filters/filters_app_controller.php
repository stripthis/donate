<?php
class FiltersAppController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function init() {
		$Filter = ClassRegistry::init('Filter');
		$filters = $Filter->find('all', array(
			'conditions' => array('user_id' => User::get('id')),
			'order' => array('Filter.name' => 'asc'),
			'contain' => false
		));
		return compact('filters');
	}
}
?>