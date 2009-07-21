<h1>Create A Gift</h1>

<p>* indicates a required field</p>
<?php
$saluteOptions = array('ms' => 'Ms.', 'mrs' => 'Mrs.', 'mr' => 'Mr.');
$titleOptions = array(
	'dr' => 'Dr.',
	'drdr' => 'Dr. Dr.',
	'prof' => 'Prof.',
	'profdr' => 'Prof. Dr.',
	'profdrdr' => 'Prof. Dr. Dr.',
	'dipl' => 'Dipl.'
);
$frequencyOptions = Configure::read('App.frequency_options');

$cookie = Common::getComponent('Cookie');


if (!empty($cData)) {
	$cData = $cData['Gift'];
}

echo $form->create('Gift', array('url' => $this->here));
echo '<fieldset><legend>Contact Information</legend></fieldset>';

$salutation = $cookie->read('salutation');
echo $form->input('salutation', array(
	'label' => 'Salutation:', 'options' => $saluteOptions,
	'selected' => !empty($salutation) ? $salutation : ''
));

$title = $cookie->read('title');
echo $form->input('title', array(
	'label' => 'Title:', 'options' => $titleOptions, 'empty' => '',
	'selected' => !empty($title) ? $title : ''
));

$fname = $cookie->read('fname');
echo $form->input('fname', array(
	'label' => 'First Name*:',
	'value' => !empty($fname) ? $fname : ''
));

$lname = $cookie->read('lname');
echo $form->input('lname', array(
	'label' => 'Last Name*:',
	'value' => !empty($lname) ? $lname : ''
));

$address = $cookie->read('address');
echo $form->input('address', array(
	'label' => 'Address / Postbox*:',
	'value' => !empty($address) ? $address : ''
));

$zip = $cookie->read('zip');
echo $form->input('zip', array(
	'label' => 'Zip Code*:',
	'value' => !empty($zip) ? $zip : ''
));

$countryId = $cookie->read('country_id');
echo $form->input('country_id', array(
	'label' => 'Country*:', 'options' => $countryOptions,
	'selected' => !empty($countryId) ? $countryId : ''
));

$email = $cookie->read('email');
echo $form->input('email', array(
	'label' => 'Email*:',
	'value' => !empty($email) ? $email : ''
));

echo '<fieldset><legend>Gift Information</legend></fieldset>';


$type = $cookie->read('type');
echo $form->input('type', array(
	'label' => 'Type:', 'options' => Configure::read('App.gift_types'),
	'selected' => !empty($type) ? $type : false
));

$amount = $cookie->read('amount');
echo $form->input('amount', array(
	'label' => 'Amount:',
	'value' => !empty($amount) ? $amount : ''
));

$frequency = $cookie->read('frequency');
echo $form->input('frequency', array(
	'label' => 'Frequency:', 'options' => $frequencyOptions,
	'selected' => !empty($frequency) ? $frequency : 'monthly'
));

$officeId = $cookie->read('office_id');
echo $form->input('office_id', array(
	'label' => 'Office:', 'options' => $officeOptions,
	'selected' => !empty($officeId) ? $officeId : false
));

$appealId = $cookie->read('appeal_id');
echo $form->input('appeal_id', array(
	'label' => 'Appeal:', 'options' => $appealOptions, 'empty' => '--',
	'selected' => !empty($appealId) ? $appealId : false
));

$description = $cookie->read('description');
echo $form->input('description', array(
	'label' => 'Comments:',
	'value' => !empty($description) ? $description : ''
));
echo $form->end('Save');
?>