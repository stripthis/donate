<?php
class MigrateGiftTypesShell extends Shell {
	var $uses = array('Office', 'GiftType', 'GiftTypesOffice');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$this->out('Removing old data ..');
		$this->GiftTypesOffice->deleteAll(true);

		$this->out('Finding offices now ..');
		$offices = $this->Office->find('all', array('fields' => array('id')));
		foreach ($offices as $office) {
			$this->GiftTypesOffice->create(array(
				'office_id' => $office['Office']['id'],
				'gift_type_id' => '4ad74347-f140-4ede-86eb-a7baa7f05a6e'
			));
			$this->GiftTypesOffice->save();
		}
		$this->out('Recalculated ' . count($offices) . ' offices');
	}
}
?>