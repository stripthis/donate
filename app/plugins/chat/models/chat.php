<?php
class Chat extends ChatAppModel {
	var $belongsTo = array('User');

	var $validate = array(
		'key' => array(
			'rule' => array('notEmpty')
		),
		'message' => array(
			'rule' => array('notEmpty')
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
			case 'latest':
				$conditions = array();
				if (isset($query['key'])) {
					$conditions['key'] = $query['key'];
				}
				$messages = $this->find('all', array(
					'conditions' => $conditions,
					'contain' => array('User(name)'),
					'order' => array('Chat.created' => 'desc'),
					'limit' => 10
				));
				asort($messages);
				return $messages;
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>