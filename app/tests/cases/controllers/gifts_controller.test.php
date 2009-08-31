<?php 
App::import('Controller', 'Gifts');
ini_set('memory_limit', '512M');
require_once(dirname(dirname(__FILE__)) . DS . 'my_test_case.php');
class GiftsControllerTest extends MyTestCase {
	var $fixtures = array(
		'app.office', 'app.gift', 'app.appeal', 'app.gateway',
		'app.gateways_office', 'app.auth_key_type'
	);
	var $dropTables = false;
	var $Sut = null;
	var $belgiumOfficeId = false;
	var $gpiOfficeId = false;
	var $gpiAppealId = false;
	var $exampleAppealId = false;
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function startTest() {
		$this->Sut = new GiftsController();
		$this->Sut->constructClasses();
		$this->Sut->Component->initialize($this->Sut);
		$this->Sut->beforeFilter();
		$this->Sut->Component->startup($this->Sut);

		$this->Gift = ClassRegistry::init('Gift');
		$this->Contact = ClassRegistry::init('Contact');
		$this->Address = ClassRegistry::init('Address');
		$this->Appeal = ClassRegistry::init('Appeal');
		$this->Office = ClassRegistry::init('Office');
		$this->Country = ClassRegistry::init('Country');
		$this->City = ClassRegistry::init('City');

		if (!$this->gpiAppealId) {
			$this->gpiAppealId = $this->Appeal->lookup(
				array('name LIKE' => '%default GPI appeal%'), 'id', false
			);
		}

		if (!$this->exampleAppealId) {
			$this->exampleAppealId = $this->Appeal->lookup(
				array('name LIKE' => '%Example%'), 'id', false
			);
		}

		if (!$this->belgiumOfficeId) {
			$this->belgiumOfficeId = $this->Office->lookup(
				array('name LIKE' => '%Belgium%'), 'id', false
			);
		}
		if (!$this->gpiOfficeId) {
			$this->gpiOfficeId = $this->Office->lookup(
				array('name LIKE' => '%International%'), 'id', false
			);
		}

		$this->Sut->params['named']['office_id'] = $this->gpiAppealId;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function endTest() {
		$this->Sut->Session->del($this->Sut->Message->sessKey);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testGiftsAddRedirectsIfNoValidAppealGiven() {
		$this->fakeRequest('get');

		$this->Sut->params['named']['appeal_id'] = '';
		$this->Sut->add();
		$this->is($this->Sut->redirectUrl, '/');

		// any non existant appeal id
		$this->Sut->redirectUrl = '';
		$this->Sut->params['named']['appeal_id'] = String::uuid();
		$this->Sut->add();
		$this->is($this->Sut->redirectUrl, '/');

		// valid appeal id
		$this->Sut->redirectUrl = false;
		$this->Sut->params['named']['appeal_id'] = $this->gpiAppealId;
		$this->Sut->add();
		$this->false($this->Sut->redirectUrl);

		// setting appeal id allowed only at step 1 if different from session office id
		$this->Sut->redirectUrl = false;
		$this->Sut->params['named']['appeal_id'] = $this->gpiAppealId;
		$this->Sut->add();
		$this->false($this->Sut->redirectUrl);

		$this->Sut->params['named']['appeal_id'] = $this->exampleAppealId;
		$this->Sut->add(2);
		$this->is($this->Sut->redirectUrl, '/');

		$this->Sut->redirectUrl = false;
		$this->Sut->params['named']['appeal_id'] = $this->gpiAppealId;
		$this->Sut->add();
		$this->false($this->Sut->redirectUrl);

		$this->Sut->params['named']['appeal_id'] = $this->gpiAppealId;
		$this->Sut->add(2);
		$this->false($this->Sut->redirectUrl);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAddSavesAppealIdInSession() {
		$appealId = $this->gpiAppealId;
		$vars = $this->testAction('/gifts/add/appeal_id:' . $appealId, array('return' => 'vars'));
		$sessAppealId = $this->Sut->Session->read($this->Sut->sessAppealKey);
		$this->is($appealId, $sessAppealId);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAddSavesDataProperlyWithoutPhone() {
		$this->Sut->dropSessionData();
		$this->fakeRequest('post');

		$this->Sut->data = array(
			'Gift' => array(
				'type' => 'donation',
				'amount' => 5,
				'frequency' => 'monthly'
			),
			'Contact' => array(
				'salutation' => 'mr',
				'fname' => 'Tim',
				'lname' => 'Koschuetzki',
				'email' => 'tkoschuetzki@aol.com'
			),
			'Address' => array(
				'line_1' => 'Hibiskusweg 26c',
				'line_2' => '',
				'city' => 'Berlin',
				'zip' => '13089',
				'country_id' => $this->Country->lookup('Germany'),
			)
		);
		$this->Sut->add();

		$sutData = $this->Sut->data;

		// test if the proper db structure was added
		$gift = $this->Gift->find('first', array(
			'conditions' => array('Gift.id' => $this->Gift->getLastInsertId()),
			'contain' => array('Contact.Address.Phone')
		));

		$gift['Address'] = $gift['Contact']['Address'][0];
		$this->is($gift['Address']['Phone'], array());
		$this->City->injectCityId($sutData);

		foreach ($sutData as $model => $modelData) {
			foreach ($modelData as $field => $value) {
				if ($field == 'city') {
					continue;
				}
				$this->eq($gift[$model][$field], $value);
			}
		}

		// test if data was written to the session
		$data = array(
			'Gift' => $this->Sut->Session->read('Gift'),
			'Contact' => $this->Sut->Session->read('Contact'),
			'Address' => $this->Sut->Session->read('Address'),
		);

		$this->is($data['Contact'], $sutData['Contact']);

		unset($data['Address']['country_name']);
		$this->is($data['Address'], $sutData['Address']);

		unset($sutData['Gift']['contact_id']);
		unset($sutData['Gift']['office_id']);
		unset($sutData['Gift']['id']);

		$this->is($data['Gift'], $sutData['Gift']);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAddSavesDataProperlyWithPhone() {
		$this->Sut->dropSessionData();
		$this->fakeRequest('post');

		$this->Sut->data = array(
			'Gift' => array(
				'type' => 'donation',
				'amount' => 5,
				'frequency' => 'monthly'
			),
			'Contact' => array(
				'salutation' => 'mr',
				'fname' => 'Tim',
				'lname' => 'Koschuetzki',
				'email' => 'tkoschuetzki@aol.com'
			),
			'Address' => array(
				'line_1' => 'Hibiskusweg 26c',
				'line_2' => '',
				'city' => 'Berlin',
				'zip' => '13089',
				'country_id' => $this->Country->lookup('Germany'),
			),
			'Phone' => array(
				'phone' => '0303424234'
			)
		);
		$this->Sut->add();
		$sutData = $this->Sut->data;

		$gift = $this->Gift->find('first', array(
			'conditions' => array('Gift.id' => $this->Gift->getLastInsertId()),
			'contain' => array('Contact.Address.Phone')
		));

		$gift['Address'] = $gift['Contact']['Address'][0];
		$gift['Phone'] = $gift['Address']['Phone'][0];
		$this->City->injectCityId($sutData);

		foreach ($sutData as $model => $modelData) {
			foreach ($modelData as $field => $value) {
				if ($field == 'city') {
					continue;
				}
				$this->eq($gift[$model][$field], $value);
			}
		}

		// test if data was written to the session
		$data = array(
			'Gift' => $this->Sut->Session->read('Gift'),
			'Contact' => $this->Sut->Session->read('Contact'),
			'Address' => $this->Sut->Session->read('Address'),
			'Phone' => $this->Sut->Session->read('Phone'),
		);

		$this->is($data['Contact'], $sutData['Contact']);

		unset($data['Address']['country_name']);
		$this->is($data['Address'], $sutData['Address']);

		unset($sutData['Gift']['contact_id']);
		unset($sutData['Gift']['office_id']);
		unset($sutData['Gift']['id']);

		$this->is($data['Gift'], $sutData['Gift']);
		$this->is($data['Phone'], $sutData['Phone']);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAmountRecalculation() {
		$this->Sut->data = array(
			'Gift' => array(
				'amount' => 5,
				'amount_other' => 55
			)
		);
		$this->fakeRequest('post');
		$this->Sut->add();
		$this->is($this->Sut->data['Gift']['amount'], 55);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testTheSingleFormIsValidated() {
		$this->fakeRequest('get');
		$this->Sut->params['named']['appeal_id'] = $this->gpiAppealId;
		$this->Sut->add();

		$this->Sut->dropSessionData();

		$count = $this->Gift->find('count');
		$this->fakeRequest('post');
		$this->Sut->add();

		$this->false(empty($this->Gift->validationErrors));
		$this->is(count($this->Sut->viewVars['flashMessages']), 1);

		$newCount = $this->Sut->Gift->find('count');
		$this->is($count, $newCount);
	}
}
?>