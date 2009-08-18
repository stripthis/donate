<?php
$this->pageTitle = "Support Us | Greenpeace International (Multistep Form Example)";
$saluteOptions = array('ms' => 'Ms.', 'mrs' => 'Mrs.', 'mr' => 'Mr.');
$titleOptions = array(
  'dr' => 'Dr.',
  'drdr' => 'Dr. Dr.',
  'prof' => 'Prof.',
  'profdr' => 'Prof. Dr.',
  'profdrdr' => 'Prof. Dr. Dr.',
  'dipl' => 'Dipl.'
);
$currencyOptions = array("EUR","USD","GBP");
$frequencyOptions = Configure::read('App.frequency_options');

if (!empty($cData)) {
  $cData = $cData['Gift'];
}
$required = '<strong class="required">*</strong>';
?>
<div id="content_wrapper">
	<div id="banner">
		<h1><?php echo $this->pageTitle; ?></h1>
		<a href="http://www.greenpeace.org" alt="Greenpeace" class="greenpeace"><span>Greenpeace</span></a>
		<a href="http://localdonate.com" alt="Greenpeace" class="donate"><span>Support Us</span></a>
	</div>
	<div id="content">
		<h1>Support Greenpeace International</h1>
		<p class="mission">
			Greenpeace relies on donations from generous individuals to carry out our work.<br/>
		In order to remain independent, we do not accept funding from governments, corporations or political parties.
		<strong>We can't do it without your help.</strong>
		</p>
		<p class="message information">Hint: <strong class="required">*</strong> indicates a required field</p>

		<?php foreach ($flashMessages as $message): ?>
			<p class="message <?php echo $message['type']; ?>"><?php echo $simpleTextile->toHtml($message['text']); ?></p>
		<?php endforeach; ?>

		<?php echo $form->create('Gift', array('url' => $this->here . '/2'))."\n"; ?>
		<?php echo $form->input( 'Gift.id', array('type' => 'hidden'))."\n"; ?>
		<?php echo $form->input( 'Gift.type', array('type' => 'hidden', "value" => "donation"))."\n"; ?>
		<?php echo $form->input( 'Gift.appeal_id', array('type' => 'hidden'))."\n"; ?>

		<fieldset>
			<legend><?php echo __("Contact Information"); ?></legend>
			<div class="input_wrapper">
				<?php
				echo $form->input('Contact.salutation', array(
					'label' => 'Salutation:', 'options' => $saluteOptions,
					'selected' => $giftForm->value('Contact', 'salutation', '', $form->data)
				))."\n";
				?>
			</div>
			<div class="spacer"></div>
			<div class="input_wrapper half">
				<?php
				echo $form->input('Contact.fname', array(
					'label' => 'First Name'. ': ' ,
					'value' => $giftForm->value('Contact', 'fname', '', $form->data)
				))."\n";
				?>
			</div>
			  <div class="input_wrapper half">
			    <?php
			      echo $form->input('Contact.lname', array(
			        'label' => 'Last Name'. ': ' . $required,
			        'value' => $giftForm->value('Contact', 'lname', '', $form->data)
			      ))."\n";
			    ?>
			  </div>
			  <div class="input_wrapper full">
			    <?php         
			      echo $form->input('Address.line_1', array(
						'label' => 'Address'. ': ' . $required,
						'value' => $giftForm->value('Address', 'line_1', '', $form->data)
					))."\n";
			    ?>
			    <?php
			      echo $form->input('Address.line_2', array(
			        'label' => "",
						'value' => $giftForm->value('Address', 'line_2', '', $form->data)
			      ))."\n";
			    ?>
			  </div>
			  <div  class="input_wrapper half">
			    <?php
			    echo $form->input('Address.zip', array(
			      'label' => 'Zip Code'. ': ' . $required,
					'value' => $giftForm->value('Address', 'zip', '', $form->data)
			    ))."\n";
			    ?>
			  </div>
			  <div class="input_wrapper half">
			    <?php
			      echo $form->input('Address.city_id', array(
			        'label' => 'City'. ': ' . $required,
						'value' => $giftForm->value('Address', 'city_id', '', $form->data)
			      ))."\n";
			    ?>
			  </div>
			  <div class="input_wrapper">
			    <?php 
			      echo $form->input('Address.country_id', array(
			        'label' => 'Country'. ': ' . $required, 'options' => $countryOptions,
						'selected' => $giftForm->value('Address', 'country_id', '', $form->data)
			      ))."\n";
			    ?>
			  </div>
			  <div class="input_wrapper half">
			    <?php
			      echo $form->input('Contact.email', array(
			        'label' => 'Email'. ': ' . $required,
						'value' => $giftForm->value('Contact', 'email', '', $form->data)
			      ))."\n";
			    ?>
			    <?php
					$value = $giftForm->value('Contact', 'newsletter', '', $form->data);
			      echo $form->input('Contact.newsletter', array(
			        'label' => 'Yes, send me updates by email', 'type' => 'checkbox', 
			        'class' => 'checkbox', 'div' => false,
						'checked' => $value ? 'checked' : ''
			      ))."\n";
			    ?>
			  </div>
			  <div class="input_wrapper half">
			    <?php 
			      echo $form->input('Phone.phone', array(
			        'label' => 'Phone'. ': ',
						'value' => $giftForm->value('Phone', 'phone', '', $form->data)
			      ))."\n";
			    ?>
			    <?php
					$value = $giftForm->value('Phone', 'contactable', '', $form->data);
			      echo $form->input('Phone.contactable', array(
			        'label' => 'Yes, it\'s ok to call me at this number', 'type' => 'checkbox',
			        'class' => 'checkbox', 'div' => false,
						'checked' => $value ? 'checked' : ''
			      ))."\n";
			    ?>
				</div>
			</fieldset>
     		<?php echo $form->end('Donate'); ?>
	</div>
</div>
	<?php echo $this->element('footer')?>