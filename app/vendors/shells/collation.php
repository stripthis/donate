<?php
class CollationShell extends Shell {
	/**
	 * Please backup your database before executing
	 * Converts all tables to character set UTF8, and collations utf8_unicode_ci
	 *
	 */
	function main() {
		App::import('Model', 'AppModel');
		$db =& ConnectionManager::getDataSource('default');

		$tables = $db->listSources();
		foreach ($tables as $table) {
			$sql = sprintf('ALTER TABLE %s CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci', $table);
			$this->out(sprintf('-> Performing the following SQL: %s', $sql));
			if (!$db->execute($sql)) {
				$this->out(sprintf('-> Error: Could not convert %s', $table));
			}
		}
		$this->out("Your tables are now UTF8 enabled");
	}
}
?>