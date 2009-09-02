<?php
class GatewaysOffice extends AppModel {
	var $belongsTo = array(
		'Office',
		'Gateway'
	);
/**
 * undocumented function
 *
 * @param string $type 
 * @param string $query 
 * @return void
 * @access public
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'by_office':
				$officeId = isset($query['office_id']) ? $query['office_id'] : false;

				$gateway = false;
				if ($officeId) {
					$gateway = $this->find('first', array(
						'conditions' => array('office_id' => $officeId)
					));
				}

				if (empty($gateway)) {
					$gateway = $this->find('first');
				}
				return $gateway;
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>