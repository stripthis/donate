<?php
class SearchController extends AppController {
	var $uses = array();
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_go() {
		Assert::false($this->isGet(), '404');

		$validTypes = array('gifts', 'transactions', 'users', 'appeals');
		$type = $this->data['Search']['resource'];
		Assert::true(in_array($type, $validTypes), '404');

		$url = array(
			'controller' => $type, 'action' => 'index',
			'?' => 'keyword=' . $this->data['Search']['keyword']
		);
		$this->redirect($url);
	}
}
?>