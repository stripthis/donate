<?php
class ConvenienceShell extends Shell {
	var $uses = array('Gift');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		// gifts - convenience calculation in afterSave()
		$this->out('Doing gifts now ..');
		$gifts = $this->Gift->find('all', array('fields' => array('id')));
		foreach ($gifts as $gift) {
			$this->Gift->set(array(
				'id' => $gift['Gift']['id'],
			));
			$this->Gift->save();
		}
		$this->out('Recalculated ' . count($gifts) . ' gifts');
	}
}
?>