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
	function testProperTabsAreShown() {
		$this->loadFixtures('User', 'Role', 'Office');
		User::logout();
		$markup = $this->testAction('/admin/auth/login', array('return' => 'contents'));
		$this->true(preg_match('/Please enter your login details/', $markup));

		$id = $this->User->lookup(array('login' => 'root@greenpeace.org'), 'id', false);
		User::login($id, true);
		$markup = $this->testAction('/admin/home', array('return' => 'contents'));
		$this->true(preg_match('/<a href="\/admin\/home" class="selected">Home<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/appeals\/index\/all">Appeals<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/gifts\/index\/all">Gifts<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/transactions\/index\/all">Transactions<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/supporters">Supporters<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/dashboards">Admin<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/help">Help<\/a>/', $markup));
		User::logout();

		$id = $this->User->lookup(array('login' => 'admin@greenpeace.org'), 'id', false);
		User::login($id, true);
		$markup = $this->testAction('/admin/home', array('return' => 'contents'));
		$this->true(preg_match('/<a href="\/admin\/home" class="selected">Home<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/appeals\/index\/all">Appeals<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/gifts\/index\/all">Gifts<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/transactions\/index\/all">Transactions<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/supporters">Supporters<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/help">Help<\/a>/', $markup));
		User::logout();

		$id = $this->User->lookup(array('login' => 'superadmin@greenpeace.org'), 'id', false);
		User::login($id, true);
		$markup = $this->testAction('/admin/home', array('return' => 'contents'));
		$this->true(preg_match('/<a href="\/admin\/home" class="selected">Home<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/appeals\/index\/all">Appeals<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/gifts\/index\/all">Gifts<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/transactions\/index\/all">Transactions<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/supporters">Supporters<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/offices\/edit">Office Config<\/a>/', $markup));
		$this->true(preg_match('/<a href="\/admin\/help">Help<\/a>/', $markup));
		User::logout();
	}
}
?>