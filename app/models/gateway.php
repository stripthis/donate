<?php
class Gateway extends AppModel {
	var $hasAndBelongsToMany = array(
		'Office' => array(
			'with' => 'GatewaysOffice'
		)
	);

	var $hasMany = array(
		'GatewaysOffice' => array(
			'dependent' => true
		)
	);
/**
 * undocumented function
 *
 * @param string 
 * @param string 
 * @return void
 * @access public
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'list_for_office':
				$Session = Common::getComponent('Session');
				$gatewaysOffices = $this->GatewaysOffice->find('all', array(
					'conditions' => array(
						'GatewaysOffice.office_id' => $Session->read('Office.id')
					),
					'contain' => array('Gateway(id, name)'),
					'order' => array('Gateway.name' => 'asc')
				));
				return Set::combine($gatewaysOffices, '/Gateway/id', '/Gateway/name');
			case 'processing_options':
				return array(
					'direct' => 'Direct',
					'redirect' => 'Redirect'
				);
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>