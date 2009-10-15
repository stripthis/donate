<?php
class MigrateLanguagesShell extends Shell {
	var $uses = array('Office', 'Language', 'LanguagesOffice');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$this->out('Removing old data ..');
		$this->LanguagesOffice->deleteAll(true);

		$this->out('Finding offices now ..');
		$offices = $this->Office->find('all', array(
			'fields' => array('languages', 'id')
		));
		foreach ($offices as $office) {
			$langs = $office['Office']['languages'];
			$langs = explode(',', $langs);
			foreach ($langs as $lang) {
				$lang = trim($lang);
				if (empty($lang)) {
					continue;
				}
				$langId = $this->Language->lookup(
					array('code' => $lang), 'id', false
				);
				if (empty($langId)) {
					$this->out('Found no id for ' . $lang);
					continue;
				}

				$this->LanguagesOffice->create(array(
					'office_id' => $office['Office']['id'],
					'language_id' => $langId
				));
				$this->LanguagesOffice->save();
			}
		}
		$this->out('Recalculated ' . count($offices) . ' offices');
	}
}
?>