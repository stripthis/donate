<?php
class Role extends AppModel {
	var $hasMany = array('User');
	var $unEditable = array('guest', 'root');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeSave() {
		if (isset($this->data['Role']['permissions'])) {
			$permissions = Configure::read('App.permission_options');

			$perms = array();
			foreach ($this->data['Role']['permissions'] as $perm => $checked) {
				if ($checked) {
					$perms[] = $perm;
				}
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
}
?>