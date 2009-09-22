<?php
class Import extends AppModel {
	var $belongsTo = array('User');

	var $validate = array(
		'serial' => array(
			'required' => array('rule' => 'notEmpty', 'message' => 'Please enter a serial.')
		)
		, 'description' => array(
			'rule' => 'notEmpty', 'message' => 'Please insert a valid description.'
		)
	);
/**
 * undocumented function
 *
 * @param string $file 
 * @param string $template 
 * @return void
 * @access public
 */
	function parseFile($file, $template) {
		$Session = Common::getComponent('Session');
		$Transaction = ClassRegistry::init('Transaction');
		$officeId = $Session->read('Office.id');

		$formats = array(
			'friends' => array(
				'delim' => '|',
				'fields' => array(
					'parent_order_id',
					'parent_currency',
					'parent_amount',
					'order_id',
					'currency',
					'amount'
				)
			)
		);
		if (!array_key_exists($template, $formats)) {
			return false;
		}
		$format = $formats[$template];

		App::import('Vendor', 'csv_parser');
		$csv = & new csv_bv($file, ',', '"' , '\\');
		$csv->SkipEmptyRows(false);
		$csv->TrimFields(TRUE);
		$num = 0;
		while ($row = $csv->NextLine()){
			$num++;

			$data = explode($format['delim'], $row[0]);

			foreach ($format['fields'] as $i => $field) {
				$$field = $data[$i];
			}
		}
	}
}
?>