<?php
class SmileysController extends AppController {
/**
 * undocumented function
 *
 * @param unknown $page
 * @return void
 * @access public
 */
	function admin_index() {
		$this->paginate['Smiley'] = array(
			'conditions' => false,
			'order' => 'Smiley.code desc',
			'limit' => 20,
			'contain' => false
		);
		$smileys = $this->paginate('Smiley');
		$this->set(compact('smileys'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_import() {
		if ($this->isGet()) {
			return;
		}

		if (empty($this->data['Smiley']['file'])) {
			return $this->Smiley->invalidate('file', __('You have to choose a file!', true));
		}
		$numImported = $this->Smiley->import($this->data['Smiley']['file']['tmp_name']);

		if ($numImported !== false) {
			$msg = sprintf(__('%s smileys imported!', true), $numImported);
			return $this->Message->add($msg, 'ok');
		}
		$msg = __('There was a problem during the import!', true);
		$this->Message->add($msg, 'error');
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id) {
		$smiley = $this->Smiley->find('first', array(
			'conditions' => array('Smiley.id' => $id),
			'contain' => false,
			'fields' => array('id')
		));
		Assert::notEmpty($smiley, '404');

		$this->Smiley->del($id);
		$msg = __('Smiley deleted.', true);
		$this->Message->add($msg, 'ok', true, $this->referer());
	}
}
?>