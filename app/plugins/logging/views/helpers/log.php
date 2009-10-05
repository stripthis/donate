<?php
class LogHelper extends AppHelper {
/**
 * undocumented function
 *
 * @param string $data 
 * @return void
 * @access public
 */
	function events($data) {
		$result = array();
		foreach ($data as $key => $row) {
			$one = $row['Log'];
			$result[$key]['Log']['id'] = $one['id'];
			$result[$key]['Log']['event'] = $username;

			// have all the detail models and change as list : 
			if (isset($one['model']) && isset($one['action']) && isset($one['change']) && isset($one['model_id'])) {
				 if ($one['action'] == 'edit') {
				 	$result[$key]['Log']['event'] .= ' edited ' . $one['change'] . ' of ' . low($one['model']) . '(id ' . $one['model_id'] . ')';
				 	// ' at ' . $one['created']; 
				 } elseif ($one['action'] == 'add') {
				 	$result[$key]['Log']['event'] .= ' added a ' . low($one['model']) . '(id ' . $one['model_id'] . ')';
				 } elseif ($one['action'] == 'delete') {
				 	$result[$key]['Log']['event'] .= ' deleted the ' . low($one['model']) . '(id ' . $one['model_id'] . ')';
				 }
			} elseif ( isset($one['model']) && isset($one['action'])  && isset($one['model_id']) ) {
                 if ($one['action'] == 'edit') {
				 	$result[$key]['Log']['event'] .= ' edited ' . low($one['model']) . '(id ' . $one['model_id'] . ')';
				 	//	' at '.$one['created']; 
				 } elseif ($one['action'] == 'add') {
				 	$result[$key]['Log']['event'] .= ' added a ' . low($one['model']) . '(id ' . $one['model_id'] . ')';
				 } elseif ($one['action'] == 'delete') {
				 	$result[$key]['Log']['event'] .= ' deleted the ' . low($one['model']) . '(id ' . $one['model_id'] . ')';
				 }
			} else {
                $result[$key]['Log']['event'] = $one['description'];
			}
		}
		return $result;
	}
}
?>