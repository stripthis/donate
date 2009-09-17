<?php 
App::import('Controller', 'Roles');
App::import('Model', 'User');
ini_set('memory_limit', '512M');
require_once(dirname(dirname(__FILE__)) . DS . 'my_test_case.php');
class RolesControllerTest extends MyTestCase {
	var $fixtures = array(
		'app.user', 'app.role', 'app.office'
	);
	var $dropTables = false;
	var $Sut = null;
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function setup() {
		$this->Sut = new RolesController();
		$this->Sut->constructClasses();
		$this->User = ClassRegistry::init('User');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testProperTabsAreShownAndSelected() {
		$this->loadFixtures('User', 'Role', 'Office');
		User::logout();
		$markup = $this->testAction('/admin/auth/login', array('return' => 'contents'));
		$this->true(preg_match('/Please enter your login details/', $markup));

		$tabs = array(
			'root@greenpeace.org' => array(
				'/admin/home' => 'Home',
				'/admin/appeals/index/all' => 'Appeals',
				'/admin/gifts/index/all' => 'Gifts',
				'/admin/transactions/index/all' => 'Transactions',
				'/admin/supporters' => 'Supporters',
				'/admin/dashboards' => 'Admin',
				'/admin/help' => 'Help',
			),
			'admin@greenpeace.org' => array(
				'/admin/home' => 'Home',
				'/admin/appeals/index/all' => 'Appeals',
				'/admin/gifts/index/all' => 'Gifts',
				'/admin/transactions/index/all' => 'Transactions',
				'/admin/supporters' => 'Supporters',
				'/admin/help' => 'Help',
			),
			'superadmin@greenpeace.org' => array(
				'/admin/home' => 'Home',
				'/admin/appeals/index/all' => 'Appeals',
				'/admin/gifts/index/all' => 'Gifts',
				'/admin/transactions/index/all' => 'Transactions',
				'/admin/supporters' => 'Supporters',
				'/admin/offices/edit' => 'Office Config',
				'/admin/help' => 'Help',
			)
		);
		foreach ($tabs as $login => $myTabs) {
			$id = $this->User->lookup(array('login' => $login), 'id', false);
			User::login($id, true);
			$markup = $this->testAction('/admin/home', array('return' => 'contents'));

			foreach ($myTabs as $link => $label) {
				$pattern = '/<a href="' . r('/', '\\/', $link) . '"[^>]*>' . $label . '<\/a>/';
				$this->true(preg_match($pattern, $markup));

				$markup = $this->testAction($link, array('return' => 'contents'));
				$pattern = '/<a href="' . r('/', '\\/', $link) . '" class="selected">' . $label . '<\/a>/';
				$this->true(preg_match($pattern, $markup));
			}
			User::logout();
		}
	}
}
?>