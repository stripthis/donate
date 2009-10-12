<?php
class Import extends AppModel {
	var $actsAs = array(
		'Containable', 'Lookupable',
		'ContinuousId' => array(
			'field' => 'serial',
			'offset' => '100000'
		),
		'SavedBy' => array(
			'createdField' => 'created_by',
			'modifiedField' => false,
			'model' => 'User'
		)
	);

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
	function parseFile($file, $template, $save = false, $importId = false) {
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
						'fields' => array('id', 'gift_id', 'gateway_id')
					));
					if (empty($parent)) {
						$result['invalid_missing_parent']++;
						continue 2;
					}
					$data['parent_id'] = $parent['Transaction']['id'];
					$data['gift_id'] = $parent['Transaction']['gift_id'];
					$data['gateway_id'] = $parent['Transaction']['gateway_id'];
				}
			}

			if ($save) {
				$data['import_id'] = $importId;
				$this->Transaction->create($data);
				$this->Transaction->save();
			}
			$result['valid']++;
		}

		return $result;
	}
}
?>