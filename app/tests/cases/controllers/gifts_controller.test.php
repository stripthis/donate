<?php 
App::import('Controller', 'Gifts');
ini_set('memory_limit', '512M');
require_once(dirname(dirname(__FILE__)) . DS . 'my_test_case.php');
class GiftsControllerTest extends MyTestCase {
	var $dropTables = false;
	var $Sut = null;
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function setup() {
		$this->Sut = new GiftsController();
		$this->Sut->constructClasses();
		$this->Sut->Component->initialize($this->Sut);
		$this->Sut->beforeFilter();
		$this->Sut->Component->startup($this->Sut);

		$this->Office = $this->Sut->Office;
		$this->belgiumOfficeId = $this->Office->lookup(
			array('name LIKE' => '%Belgium%'), 'id', false
		);
		$this->gpiOfficeId = $this->Office->lookup(
			array('name LIKE' => '%Greenpeace International%'), 'id', false
		);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testGiftsAddRedirectsIfNoValidOfficeGiven() {
		$this->fakeRequest('get');

		// no office id
		$this->Sut->add();
		$this->is($this->Sut->redirectUrl, '/');

		// any non existant office id
		$this->Sut->redirectUrl = '';
		$this->Sut->params['named']['office_id'] = String::uuid();
		$this->Sut->add();
		$this->is($this->Sut->redirectUrl, '/');

		// valid office id
		$this->Sut->redirectUrl = false;
		$this->Sut->params['named']['office_id'] = $this->belgiumOfficeId;
		$this->Sut->add();
		$this->false($this->Sut->redirectUrl);

		// setting office id allowed only at step 1
		$this->Sut->redirectUrl = false;
		$this->Sut->params['named']['office_id'] = $this->gpiOfficeId;
		$this->Sut->add();
		$this->false($this->Sut->redirectUrl);

		$this->Sut->add(2);
		$this->is($this->Sut->redirectUrl, '/');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAddSavesSessionDataProperly() {
		// office id was saved in session?
		$officeId = $this->belgiumOfficeId;
		$vars = $this->testAction('/gifts/add/office_id:' . $officeId, array('return' => 'vars'));
		$sessOfficeId = $this->Sut->Session->read($this->Sut->sessOfficeKey);
		$this->is($officeId, $sessOfficeId);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAddValidation() {
		$count = $this->Sut->Gift->find('count');
		$this->fakeRequest('post');
		$this->Sut->add();
		$this->is(count($this->Sut->viewVars['flashMessages']), 1);

		$newCount = $this->Sut->Gift->find('count');
		$this->is($count, $newCount);
	}
}
?>