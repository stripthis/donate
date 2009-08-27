<?php
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html');
	var $uses = array('User', 'Appeal');
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}

		if ($page == 'home') {
			$appeals = $this->Appeal->find('all', array(
				'contain' => false,
				'fields' => array('name', 'id'),
				'order' => array('name' => 'asc')
			));
			$this->set(compact('appeals'));
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title'));
		$this->render(join('/', $path));
	}
}
?>