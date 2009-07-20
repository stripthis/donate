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
?>
<?php echo $form->create('Gift', array('url' => $this->here))?>
<fieldset><legend>Contact Information</legend></fieldset>
<?php echo $form->input('salutation', array('label' => 'Salutation:', 'options' => $saluteOptions))?>
<?php echo $form->input('title', array('label' => 'Title:', 'options' => $titleOptions, 'empty' => ''))?>
<?php echo $form->input('fname', array('label' => 'First Name*:'))?>
<?php echo $form->input('lname', array('label' => 'Last Name*:'))?>
<?php echo $form->input('address', array('label' => 'Address / Postbox*:'))?>
<?php echo $form->input('zip', array('label' => 'Zip Code*:'))?>
<?php echo $form->input('country_id', array('label' => 'Country*:', 'options' => $countryOptions))?>
<?php echo $form->input('email', array('label' => 'Email*:'))?>

<fieldset><legend>Gift Information</legend></fieldset>
<?php echo $form->input('type', array('label' => 'Type:', 'options' => Configure::read('App.gift_types')))?>
<?php echo $form->input('amount', array('label' => 'Amount:'))?>
<?php echo $form->input('frequency', array('label' => 'Frequency:', 'options' => $frequencyOptions, 'selected' => 'monthly'))?>
<?php echo $form->input('description', array('label' => 'Comments:'))?>
<?php echo $form->input('appeal_id', array('label' => 'Appeal:', 'options' => $appealOptions, 'empty' => '--'))?>
<?php echo $form->end('Save')?>