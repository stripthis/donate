<?php
class Import extends AppModel {
	var $belongsTo = array('User');
	var $hasMany = array(
		'Transaction'
	);

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
	function parseFile($file, $template, $save = false) {
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

		$result = array(
			'valid' => 0,
			'invalid_missing_parent' => 0
		);
		while ($row = $csv->NextLine()){
			$num++;

			$values = explode($format['delim'], $row[0]);
			$data = array();
			foreach ($format['fields'] as $i => $field) {
				$data[$field] = $values[$i];

				if ($field == 'parent_order_id') {
					$parent = $this->Transaction->find('first', array(
						'conditions' => array('order_id' => $values[$i]),
						'fields' => array('id')
					));
					if (empty($parent)) {
						$result['invalid_missing_parent']++;
						continue 2;
					}
					$data['parent_id'] = $parent[__CLASS__]['id'];
				}
			}

			if ($save) {
				$this->Transaction->create($data);
				$this->Transaction->save();
			}
			$result['valid']++;
		}

		return $result;
	}
}
?>