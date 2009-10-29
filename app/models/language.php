<?php
class Language extends AppModel {
	var $hasMany = array(
		'LanguagesOffice' => array(
			'dependent' => true
		)
	);
/**
 * undocumented function
 *
 * @param string 
 * @param string 
 * @return void
 * @access public
 */
	function find($type, $query = array()) {
		$args = func_get_args();
		switch ($type) {
			case 'options':
				$Session = Common::getComponent('Session');
				$langs = $this->LanguagesOffice->find('all', array(
					'conditions' => array(
						'office_id' => $Session->read('Office.id')
					),
					'fields' => array('language_id')
				));
				$conditions = array();
				if (!empty($langs)) {
					$conditions['id'] = Set::extract('/LanguagesOffice/language_id', $langs);
				}
				return $this->find('list', array(
					'conditions' => $conditions,
					'fields' => array('code', 'name'),
					'order' => array('name' => 'asc')
				));
		}
		return call_user_func_array(array('parent', 'find'), $args);
	}
}
?>