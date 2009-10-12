<?php
class MyLogHelper extends AppHelper {
/**
 * undocumented function
 *
 * @param string $data 
 * @return void
 * @access public
 */
	function events($data, $options = array()) {
		$defaults = array(
			'showIds' => true,
			'ids' => array()
		);
		$options = am($defaults, $options);

		$result = array();
		foreach ($data as $key => $row) {
			$one = $row['Log'];
			$result[$key]['Log']['id'] = $one['id'];
			$result[$key]['Log']['continuous_id'] = $one['continuous_id'];
			$event = $row['User']['name'];
			$model = low($one['model']);
			
			if (isset($one['model']) && isset($one['action']) && isset($one['change'])) {
				 if ($one['action'] == 'edit') {
				 	$event .= ' edited ' . $one['change'] . ' of ' . $model;
				 } elseif ($one['action'] == 'add') {
					$event .= ' added a ' . $model;
				 } elseif ($one['action'] == 'delete') {
				 	$event .= ' deleted the ' . $model;
				 }
			} elseif (isset($one['model']) && isset($one['action'])) {
                 if ($one['action'] == 'edit') {
				 	$event .= ' edited ' . $model;
				 } elseif ($one['action'] == 'add') {
				 	$event .= ' added a ' . $model;
				 } elseif ($one['action'] == 'delete') {
				 	$event .= ' deleted the ' . $model;
				 }
			} else {
                $event = $one['description'];
			}

			if ($options['showIds']) {
				$id = 'id';
				if (isset($options['ids'][$one['model']])) {
					$id = $options['ids'][$one['model']];
				}

				$event .= '(' . $id . ' ' . $row[$one['model']][$id] . ')';
			}
			$result[$key]['Log']['event'] = $event;

			if ($options['showData'] && isset($one['change'])) {
				$result[$key]['Log']['change'] = explode(',', $one['change']);
			}
			$result[$key]['Log']['created'] = $one['created'];
		}
		return $result;
	}
}
?>