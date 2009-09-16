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
				'conditions' => array('admin' => false, 'status' => 'published'),
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
		$this->layout = 'empty';
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
		$this->render('start');
		return;
		
		$path = func_get_args();
		
		if(empty($path)){
			if(isset($this->params['section'])){
				$path[] = $this->params['section'];
			}
			if(isset($this->params['page'])){
				$path[] = $this->params['page'];
			}
			if(isset($this->params['subpage'])){
				$path[] = $this->params['subpage'];
			}
		}
		
		$count = count($path);
		$this->viewPath = 'pages' . DS . 'admin' . DS;
		switch($count){
			case 0:
				$this->redirect('/','error',true);
			break;
			case 1:
				//$page = $path[0];
			case 2:
				//$page = $path[0];
				//$subpage = $path[1];
				$this->render('help/start');
			break;
		}
		
		$title = Inflector::humanize($path[$count - 1]);
		$this->set(compact('page', 'subpage', 'title'));
		$this->layout = 'admin';
		$this->render(join('/', $path));
	}
}
?>