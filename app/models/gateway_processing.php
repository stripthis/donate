<?php
class GatewayProcessing extends AppModel {
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
			case 'options':
				return $this->find('list', array(
					'fields' => array('id', 'humanized'),
					'order' => array('label' => 'asc')
				));
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>