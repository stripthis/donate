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

		switch ($page) {
			case 'home':
			case 'country_selector':
				if ($page == 'home') {
					$path[0] = $page = 'country_selector';
				}
				$appeals = $this->Appeal->find('all', array(
					'conditions' => array(
						'Appeal.published' => '1',
						'Office.live' => true
					),
					'contain' => array('Office'),
					'fields' => array('name', 'id'),
					'order' => array('name' => 'asc')
				));

				$this->set(compact('appeals'));
			break;
		}

		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}

		$this->set(compact('page', 'subpage', 'title'));
		$this->layout = 'default';
		$this->render(join('/', $path));
	}
/**
 * Admin Page  Display
 *
 * @param mixed What page to display
 * @access public
 */
	function admin_display() {
		$this->viewPath = 'pages' . DS . 'admin' . DS . 'help';
		$path = func_get_args();
		$count = count($path);
		if (!$count) {
			$page = 'start';
		} else {
			$page = $path[0];
		}
		return $this->render($page);
	}
}
?>