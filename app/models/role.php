<?php
class Role extends AppModel {
	var $hasMany = array('User');
	var $belongsTo = array('Office'); // optional, can also be a global role
	var $unEditable = array('guest', 'root');
	
	var $validate = array(
		'description' => array(
			'maxlength' => array(
				'allowEmpty' => true,
				'rule' => array('maxLength', '255'),
				'message' => 'The description length is limited to 256 characters.',
				'is_required' => false,
			)
		)
	);
	
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		if (isset($this->data['Role']['permissions'])) {
			$permissions = Configure::read('App.permissions.options');

			$perms = array();
			foreach ($this->data['Role']['permissions'] as $perm => $checked) {
				if ($checked) {
					$perms[] = $perm;
				}
			}

			if ($this->data[__CLASS__]['id']) {
				$userIds = $this->User->find('all', array(
					'conditions' => array('role_id' => $this->data[__CLASS__]['id']),
					'fields' => array('id')
				));
				$userIds = Set::extract('/User/id', $userIds);
				Common::getComponent('Session')->logout($userIds);
			}

			$diff = array_diff($permissions, $perms);
			if (empty($diff)) {
				$this->data[__CLASS__]['permissions'] = '';
				return true;
			}

			$s = '';
			foreach ($diff as $perm) {
				$s .= '!' . $perm . ',';
			}
			$this->data[__CLASS__]['permissions'] = substr($s, 0, -1);
		}
		return true;
	}

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
				$conditions = array('Role.name <>' => 'guest');
				if (!User::is('root')) {
					$conditions[] = "Role.name <> 'root'";
				}
				return $this->find('list', array(
					'conditions' => $conditions,
					'order' => array('name' => 'desc')
				));
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>