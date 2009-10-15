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
		$this->Frequency = ClassRegistry::init('Frequency');

		$models = array('Gift', 'Contact', 'Address', 'Phone');
		AppModel::resetRequired($models);

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
	function testAddSavesDataProperly() {
		$this->Sut->dropSessionData();
		$this->fakeRequest('post');

		$this->Sut->data = array(
			'Gift' => array(
				'type' => 'donation',
				'amount' => 5,
				'frequency_id' => $this->Frequency->lookup('monthly', 'id', false)
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

		// test that data is not preserved in the session
		$data = array(
			'Gift' => $this->Sut->Session->read('Gift'),
			'Contact' => $this->Sut->Session->read('Contact'),
			'Address' => $this->Sut->Session->read('Address'),
			'Phone' => $this->Sut->Session->read('Phone'),
		);

		$this->false($data['Gift']);
		$this->false($data['Contact']);
		$this->false($data['Address']);
		$this->false($data['Phone']);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAmountRecalculation() {
		$this->Sut->data = array('Gift' => array(
			'amount' => 5,
			'amount_other' => 55
		));
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
	function testAnIncompleteGiftIsAlwaysAdded() {
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
		$this->is($count + 1, $newCount);

		$last = $this->Sut->Gift->find('first', array(
			'order' => array('created' => 'desc')
		));
		$this->is($last['Gift']['complete'], '0');
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testMultiStepFormCreatesRelatedData() {
		$this->fakeRequest('get');
		$this->Sut->params['named']['appeal_id'] = $this->exampleAppealId;
		$this->Sut->add();
		$this->Sut->dropSessionData();

		$this->fakeRequest('post');
		$sutData = array(
			'Gift' => array(
				'type' => 'donation',
				'amount' => 23,
				'frequency_id' => $this->Frequency->lookup('annually', 'id', false)
			),
			'Contact' => array(
				'salutation' => 'mr',
				'email' => 'tkoschuetzki@aol.com'
			),
			'Address' => array(
				'line_1' => 'Hibiskusweg 26c',
				'line_2' => '',
				'country_id' => $this->Country->lookup('Germany'),
			)
		);
		$this->Sut->data = $sutData;
		$this->Sut->add();
		$id = $this->Gift->getLastInsertId();
		$this->assertFalse(empty($id));
		$gift = $this->Gift->find('first', array(
			'conditions' => array('Gift.id' => $id),
			'contain' => array('Contact.Address.Phone')
		));

		$this->eq($sutData['Gift']['type'], $gift['Gift']['type']);
		$this->eq($sutData['Gift']['frequency_id'], $gift['Gift']['frequency_id']);
		$this->eq($sutData['Gift']['amount'], $gift['Gift']['amount']);
		$this->eq($sutData['Contact']['salutation'], $gift['Contact']['salutation']);
		$this->eq($sutData['Contact']['email'], $gift['Contact']['email']);
		$this->eq($sutData['Address']['line_1'], $gift['Contact']['Address'][0]['line_1']);
		$this->eq($sutData['Address']['country_id'], $gift['Contact']['Address'][0]['country_id']);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function testAppealOfNotLiveOfficeCausesRedirect() {
		$this->fakeRequest('get');
		$appealId = $this->Appeal->lookup(array('name' => 'Not Live Appeal'), 'id', false);
		$this->Sut->params['named']['appeal_id'] = $appealId;
		$this->Sut->redirectUrl = '';
		$this->Sut->add();
		$this->false(empty($this->Sut->redirectUrl));
	}
}
?>