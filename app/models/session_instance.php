<?php
class SessionInstance extends AppModel {
	public $name = 'SessionInstance';
/**
 * beforeSave callback, used to attach User ID to SessionInstance
 *
 * @return bool Success
 * @access public
 */
	public function beforeSave() {
		$success = parent::beforeSave();
		if ($success && empty($this->data[$this->alias]['user_id'])) {
			$this->data[$this->alias]['user_id'] = User::get('id');
		}
		return $success;
	}
/**
 * Get session record for given user.
 *
 * @param string $userId User ID
 * @param array $conditions Conditions
 * @param bool $gc Set to true to run garbage collector before looking for record
 * @return mixed Record, or false
 * @access public
 */
	public function userSession($userId, $conditions = array(), $gc = false) {
		if ($gc) {
			$this->gc();
		}
		$rand = rand();
		$conditions = array_merge(array($this->alias . '.user_id' => $userId), $conditions);
		$conditions[$rand] = $rand;
		$recursive = -1;
		$result = $this->find('first', array(
			'conditions' => $conditions,
			'recursive' => -1
		));
		return $result;
	}
/**
 * Method used to read from a database session.
 *
 * @param mixed $key The key of the value to read
 * @return mixed The value of the key or false if it does not exist
 * @access public
 */
	public function get($key) {
		$data = false;
		$time = time();
		$rand = rand();
		$row = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array($this->alias . '.key' => $key, $rand => $rand, $time => $time),
			'fields' => array($this->alias . '.data')
		));

		if (!empty($row) && isset($row[$this->alias]) && isset($row[$this->alias]['data'])) {
			$data = $row[$this->alias]['data'];
		}

		return $data;
	}
/**
 * Helper function called on write for database sessions.
 *
 * @param mixed $key The name of the var
 * @param mixed $value The value of the var
 * @return boolean Success
 * @access public
 */
	public function write($key, $value) {
		switch (Configure::read('Security.level')) {
			case 'high':
				$factor = 10;
			break;
			case 'medium':
				$factor = 100;
			break;
			case 'low':
				$factor = 300;
			break;
			default:
				$factor = 10;
			break;
		}

		$time = time();
		$rand = rand();
		$row = array(
			$this->alias => array(
				'key' => $key,
				'data' => $value,
				'expires' => $time +  Configure::read('Session.timeout') * $factor
			)
		);

		// When session is being written at end of operation, DB might be closed
		$Db =& ConnectionManager::getDataSource($this->useDbConfig);

		if (!$Db->isConnected()) {
			$Db->connect();
		}

		$id = $this->field($this->primaryKey, array(
			$this->alias . '.key' => $key,
			$rand => $rand,
			$time => $time
		));

		if (!empty($id)) {
			$row[$this->alias][$this->primaryKey] = $id;
		} else {
			$this->create();
		}
		return $this->save($row);
	}
/**
 * Helper function called on gc for database sessions.
 *
 * @param integer $expires Timestamp (defaults to current time)
 * @return boolean Success
 * @access public
 */
	public function gc($expires = null) {
		if (empty($expires)) {
			$expires = time();
		}

		$rand = rand();
		return $this->deleteAll(array(
			$this->alias . '.expires <' => $expires, $rand => $rand
		));
	 }
}
?>