<?php
ini_set('memory_limit', '1024M');
App::import(array('Model', 'AppModel'));
/**
 * Removes user records under certain conditions
 *
 * @package default
 * @access public
 */
class RemoveCacheShell extends Shell {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$paths = array(
			APP . 'tmp',
			APP . 'tmp' . DS . 'cache',
			APP . 'tmp' . DS . 'cache' . DS . 'persistent'
		);

		foreach ($paths as $path) {
			$folder = new Folder($path);
			$contents = $folder->read();
			$files = $contents[1];
			foreach ($files as $file) {
				if (preg_match('/^cake_/', $file)) {
					$this->out($path . DS . $file);
					@unlink($path . DS . $file);
				}
			}
		}

		$path = APP . 'tmp' . DS . 'cache' . DS . 'views';
		$folder = new Folder($path);
		$contents = $folder->read();
		$files = $contents[1];
		foreach ($files as $file) {
			$this->out($path . DS . $file);
			@unlink($path . DS . $file);
		}
	}
}
?>