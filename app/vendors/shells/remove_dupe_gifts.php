<?php
class RemoveDupeGiftsShell extends Shell {
	var $uses = array('Gift');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$this->out('Finding dupe Gifts now ..');
		$gifts = $this->Gift->find('all', array(
			'fields' => array('id', 'name'),
			'group' => array('name')
		));

		foreach ($gifts as $gift) {
			extract($gift['Gift']);
			$this->Gift->deleteAll(array(
				'Gift.id <>' => $id,
				'Gift.name' => $name
			));
		}
		$this->out('Went through ' . count($gifts) . ' gifts to remove dupes');
	}
}
?>