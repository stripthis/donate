<?php
class MigrateCurrenciesShell extends Shell {
	var $uses = array('Office', 'Currency', 'CurrenciesOffice');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function main() {
		$this->out('Removing old data ..');
		$this->CurrenciesOffice->deleteAll(true);

		$this->out('Finding offices now ..');
		$offices = $this->Office->find('all', array(
			'fields' => array('currencies', 'id')
		));
		foreach ($offices as $office) {
			$currencies = $office['Office']['currencies'];
			$currencies = explode(',', $currencies);
			foreach ($currencies as $curr) {
				$curr = trim($curr);
				if (empty($curr)) {
					continue;
				}
				$currencyId = $this->Currency->lookup(
					array('iso_code' => $curr), 'id', true
				);
				if (empty($currencyId)) {
					$this->out('Found no id for ' . $lang);
					continue;
				}

				$this->CurrenciesOffice->create(array(
					'office_id' => $office['Office']['id'],
					'currency_id' => $currencyId
				));
				$this->CurrenciesOffice->save();
			}
		}
		$this->out('Recalculated ' . count($offices) . ' offices');
	}
}
?>