	<div id="content_wrapper">
		<div id="banner">
	    <h1>Greenpeace - Support Us</h1>
	    <a href="http://www.greenpeace.org" alt="Greenpeace" class="greenpeace"><span>Greenpeace</span></a>
	    <a href="http://localdonate.com" alt="Greenpeace" class="donate"><span>Support Us</span></a>
	  </div>
		<div id="content">
			<h1>Support Greenpeace</h1>
			<p class="mission">
				Greenpeace relies on donations from generous individuals to carry out our work.
				In order to remain independent, we do not accept funding from governments, corporations or political parties.
				<strong>We can't do it without your help.</strong>
			</p>
			
			
<?php
$saluteOptions = array('ms' => 'Ms.', 'mrs' => 'Mrs.', 'mr' => 'Mr.');
/*
$titleOptions = array(
	'dr' => 'Dr.',
	'drdr' => 'Dr. Dr.',
	'prof' => 'Prof.',
	'profdr' => 'Prof. Dr.',
	'profdrdr' => 'Prof. Dr. Dr.',
	'dipl' => 'Dipl.'
);*/
$frequencyOptions = Configure::read('App.frequency_options');
$cookie = Common::getComponent('Cookie');

if (!empty($cData)) {
	$cData = $cData['Gift'];
}

echo $form->create('Gift', array('url' => $this->here));
?>
<p><strong class="required"> * indicates a required field</strong></p>
<fieldset><legend>Gift Information</legend>

<label for="amount"><strong>Amount: </strong><strong class="required">*</strong></label>
<label class="option"><input name="data[gift][amount]" value="5" class="radio" type="radio"> 5€</label>
<label class="option"><input name="data[gift][amount]" value="10" class="radio" type="radio"> 10€</label>
<label class="option"><input name="data[gift][amount]" value="15" class="radio" type="radio"> 15€</label>
<label class="option">
	<input name="data[gift][amount]" value="other" class="form-radio" type="radio" style="margin-top:5px;"> Other 
	<input name="data[gift][amount]" type="text" style="width:50px;font-size:1em;"/> €
</label>

<?php
/*
$type = $cookie->read('type');
echo $form->input('type', array(
	'label' => 'Type:', 'options' => Configure::read('App.gift_types'),
	'selected' => !empty($type) ? $type : false
));
*/
/*
$amount = $cookie->read('amount');
echo $form->input('amount', array(
	'label' => 'Amount:',
	'value' => !empty($amount) ? $amount : ''
));
*/
$frequency = $cookie->read('frequency');
echo $form->input('frequency', array(
	'label' => 'Frequency:', 'options' => $frequencyOptions,
	'selected' => !empty($frequency) ? $frequency : 'monthly'
));

/*
$officeId = $cookie->read('office_id');
echo $form->input('office_id', array(
	'label' => 'Office:', 'options' => $officeOptions,
	'selected' => !empty($officeId) ? $officeId : false
));
*/
/*
$appealId = $cookie->read('appeal_id');
echo $form->input('appeal_id', array(
	'label' => 'Appeal:', 'options' => $appealOptions, 'empty' => '--',
	'selected' => !empty($appealId) ? $appealId : false
));
*/
/*
$description = $cookie->read('description');
echo $form->input('description', array(
	'label' => 'Comments:',
	'value' => !empty($description) ? $description : ''
));
*/


echo '</fieldset><fieldset><legend>Contact Information</legend>';

$salutation = $cookie->read('salutation');
echo $form->input('salutation', array(
	'label' => 'Salutation:', 'options' => $saluteOptions,
	'selected' => !empty($salutation) ? $salutation : ''
));
/*
$title = $cookie->read('title');
echo $form->input('title', array(
	'label' => 'Title:', 'options' => $titleOptions, 'empty' => '',
	'selected' => !empty($title) ? $title : ''
));
*/
$fname = $cookie->read('fname');
echo $form->input('fname', array(
	'label' => 'First Name'. ': ' . "<strong class='required'>*</strong>",
	'value' => !empty($fname) ? $fname : ''
));

$lname = $cookie->read('lname');
echo $form->input('lname', array(
	'label' => 'Last Name'. ': ' . "<strong class='required'>*</strong>",
	'value' => !empty($lname) ? $lname : ''
));

$address = $cookie->read('address1');
echo $form->input('address', array(
	'label' => 'Address'. ': ' . "<strong class='required'>*</strong>",
	'value' => !empty($address1) ? $address1 : ''
));
echo $form->input('address2', array(
	'label' => "",
	'value' => !empty($address2) ? $address2 : ''
));

$city = $cookie->read('city');
echo $form->input('City', array(
	'label' => 'City'. ': ' . "<strong class='required'>*</strong>",
	'value' => !empty($city) ? $city : ''
));

$zip = $cookie->read('zip');
echo $form->input('zip', array(
	'label' => 'Zip Code'. ': ' . "<strong class='required'>*</strong>",
	'value' => !empty($zip) ? $zip : ''
));
/*
$countryId = $cookie->read('country_id');
echo $form->input('country_id', array(
	'label' => 'Country'. ': ' . "<strong class='required'>*</strong>", 'options' => $countryOptions,
	'selected' => !empty($countryId) ? $countryId : ''
));
*/
$email = $cookie->read('email');
echo $form->input('email', array(
	'label' => 'Email'. ': ' . "<strong class='required'>*</strong>",
	'value' => !empty($email) ? $email : ''
));

echo $form->input('terms', array(
	'label' => 'I want to receive the newsletter', 'type' => 'checkbox', 'class' => 'required checkbox', 'div' => false));
?>
	</fieldset>
<?php echo $form->end('Donate'); ?>
</div>
</div>
<div class="clear"></div>