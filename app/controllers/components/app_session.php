<?php
App::import('Component', 'Session');

class AppSessionComponent extends SessionComponent {
	var $SessionInstance = null;
	var $initialized = false;
/**
 * Helper method to initialize a session, based on Cake core settings.
 *
 * @access private
 */
	function __initSession() {
		parent::__initSession();

		if (Configure::read('Session.model') === null) {
			trigger_error(__("You must set the Configure::write('Session.model') in core.php to use model storage"), E_USER_WARNING);
			exit();
		}

		if (Configure::read('Session.save') == 'model' && !$this->initialized) {
			if (Configure::read('Session.model') !== null && is_null($this->SessionInstance)) {
				$this->SessionInstance =& ClassRegistry::init(Configure::read('Session.model'));
			}

			session_set_save_handler(array($this,'__modelOpen'),
									array($this, '__modelClose'),
									array($this, '__modelRead'),
									array($this, '__modelWrite'),
									array($this, '__modelDestroy'),
									array($this, '__modelGc'));
			$this->initialized = true;
		}
	}
/**
 * Method called on open of a database session.
 *
 * @return boolean Success
 * @access private
 */
	function __modelOpen() {
		return true;
	}
/**
 * Method called on close of a database session.
 *
 * @return boolean Success
 * @access private
 */
	function __modelClose() {
		$probability = mt_rand(1, 150);
		if ($probability <= 3) {
			$this->__modelGc();
		}
		return true;
	}
/**
 * Method used to read from a database session.
 *
 * @param mixed $key The key of the value to read
 * @return mixed The value of the key or false if it does not exist
 * @access private
 */
	function __modelRead($key) {
		$data = false;
		$time = time();
		$rand = rand();
		$row = $this->SessionInstance->find('first', array(
			'recursive' => -1,
			'conditions' => array($this->SessionInstance->alias . '.key' => $key, $rand => $rand, $time => $time),
			'fields' => array($this->SessionInstance->alias . '.data')
		));

		if (!empty($row) && isset($row[$this->SessionInstance->alias]) && isset($row[$this->SessionInstance->alias]['data'])) {
			$data = $row[$this->SessionInstance->alias]['data'];
		}

		return $data;
	}
/**
 * Helper function called on write for database sessions.
 *
 * @param mixed $key The name of the var
 * @param mixed $value The value of the var
 * @return boolean Success
 * @access private
 */
	function __modelWrite($key, $value) {
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
		$expires = time() + Configure::read('Session.timeout') * $factor;
		$time = time();
		$rand = rand();
		$row = array($this->SessionInstance->alias => array('key' => $key, 'data' => $value, 'expires' => $expires));

		// When session is being written at end of operation, DB might be closed

		$Db =& ConnectionManager::getDataSource($this->SessionInstance->useDbConfig);
		if (!$Db->isConnected()) {
			$Db->connect();
		}

		// Proceed with saving

		$id = $this->SessionInstance->field(
			$this->SessionInstance->primaryKey,
			array(
				$this->SessionInstance->alias . '.key' => $key,
				$rand => $rand,
				$time => $time
			)
		);

		if (!empty($id)) {
			$row[$this->SessionInstance->alias][$this->SessionInstance->primaryKey] = $id;
		} else {
			$this->SessionInstance->create();
		}
		return $this->SessionInstance->save($row);
	}
/**
 * Method called on the destruction of a database session.
 *
 * @param integer $key Key that uniquely identifies session in database
 * @return boolean Success
 * @access private
 */
	function __modelDestroy($key) {
		return $this->SessionInstance->delete($key);
	}
/**
 * Helper function called on gc for database sessions.
 *
 * @param integer $expires Timestamp (defaults to current time)
 * @return boolean Success
 * @access private
 */
	function __modelGc($expires = null) {
		return $this->SessionInstance->deleteAll(array($this->SessionInstance->alias . '.expires <' => time()));
	 }
}
?>