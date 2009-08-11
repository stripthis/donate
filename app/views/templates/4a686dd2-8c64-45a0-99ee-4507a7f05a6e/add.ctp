<?php
/**
 * "One Step" Donation page (cf. redirect model)
 * 
 * Copyright (c)  GREENPEACE INTERNATIONAL 2009
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   GREENPEACE INTERNATIONAL (c) 2009
 * @link        http://www.greenpeace.org/international/supportus
 */
	$this->pageTitle = "Support Us | Greenpeace International";
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
	$cookie = Common::getComponent('Cookie');
	$monthOptions = Gift::getMonthOptions();
	$yearOptions = Gift::getYearOptions();
	
	if (!empty($cData)) {
	  $cData = $cData['Gift'];
	}
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
      <?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
      <?php echo $form->input( 'Gift.id', array('type' => 'hidden'))."\n"; ?>
      <?php echo $form->input( 'Gift.type', array('type' => 'hidden', "value" => "donation"))."\n"; ?>
      <?php echo $form->input( 'Gift.appeal_id', array('type' => 'hidden'))."\n"; ?>
      <fieldset class="left" id="gift_type">
        <legend><?php echo __("Gift Information"); ?></legend>
        <div class="input_wrapper radio">
          <label for="amount" class="option_title"><strong>Amount: </strong><strong class="required">*</strong></label>
          <label class="option"><input name="data[Gift][amount]" value="5" class="radio" type="radio" <?php echo $common->giftRadioSelected(5); ?>> 5€</label>
          <label class="option"><input name="data[Gift][amount]" value="10" class="radio" type="radio" <?php echo $common->giftRadioSelected(10); ?>> 10€</label>
          <label class="option"><input name="data[Gift][amount]" value="15" class="radio" type="radio" <?php echo $common->giftRadioSelected(15); ?>> 15€</label>
        </div>
        <div class="input_wrapper radio" id="other_amount">
          <label class="option">
            <input name="data[Gift][amount]" value="other" class="form-radio" type="radio" <?php echo $common->giftRadioSelected('other'); ?>> Other
          </label>
          <input name="data[Gift][amount_other]" type="text" class="text" id="txtOtherAmount" value="<?php echo $common->giftTextAmount(); ?>"/> 
          <?php
             echo $form->input('currency', array(
              'label' => '', 
              'options' => $currencyOptions
            ))."\n";
          ?>
          <?php 
          	if($form->isFieldError('Gift.amount')) {
          		echo '<div class="error">' . $form->error("Gift.amount") . '</div>';
          	}
          	if($form->isFieldError('Gift.currency')) {
          		echo '<div class="error">' . $form->error("Gift.currency"). '</div>';
          	}
          ?>
        </div>
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
          'label' => 'Frequency'. ': ' . "<strong class='required'>*</strong>",
          'options' => $frequencyOptions,
          'selected' => !empty($frequency) ? $frequency : 'monthly'
        ))."\n";
        
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
        ?>
      </fieldset>
      <div class="form_decoration half left" id="activist">
        <p>
          &#x201c; Greenpeace exists because this fragile Earth deserves a voice. 
          It needs solutions. It needs change. It needs action. &#x201d;
        </p>
      </div>
      <div class="spacer"></div>
      <fieldset id="contact">
        <legend><?php echo __("Contact Information"); ?></legend>
        <div class="input_wrapper">
          <?php
            echo $form->input('Contact.salutation', array(
              'label' => 'Salutation:', 
              'options' => $saluteOptions
            ))."\n";
          ?>
        </div>
        <div class="spacer"></div>
        <?php
          /*
          $title = $cookie->read('title');
          echo $form->input('title', array(
            'label' => 'Title:', 'options' => $titleOptions, 'empty' => '',
            'selected' => !empty($title) ? $title : ''
          ));
          */
        ?>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Contact.fname', array(
              'label' => 'First Name'. ': ' 
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Contact.lname', array(
              'label' => 'Last Name'. ': ' . "<strong class='required'>*</strong>",
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper full">
          <?php
            echo $form->input('Address.line_1', array(
              'label' => 'Address'. ': ' . "<strong class='required'>*</strong>"
            ))."\n";
          ?>
          <?php
            echo $form->input('Address.line_2', array(
              'label' => ""
            ))."\n";
          ?>
        </div>
        <div  class="input_wrapper half">
          <?php
          echo $form->input('Address.zip', array(
            'label' => 'Zip Code'. ': ' . "<strong class='required'>*</strong>"
          ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Address.city_id', array(
              'label' => 'City'. ': ' . "<strong class='required'>*</strong>"
            ))."\n";
          ?>
        </div>
        <?php
        /* <div class="input_wrapper">
        $stateId = $cookie->read('state_id');
        echo $form->input('state_id', array(
          'label' => 'State:', 'options' => $stateOptions, 'empty' => '--',
          'selected' => !empty($stateId) ? $stateId : false
        ));
        </div> */
        ?>
        <div class="input_wrapper">
          <?php 
            echo $form->input('Address.country_id', array(
              'label' => 'Country'. ': ' . "<strong class='required'>*</strong>", 
              'options' => $countryOptions
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Contact.email', array(
              'label' => 'Email'. ': ' . "<strong class='required'>*</strong>"
            ))."\n";
          ?>
          <?php
            echo $form->input('Contact.newsletter', array(
              'label' => 'Yes, send me updates by email', 'type' => 'checkbox', 
              'class' => 'checkbox', 'div' => false
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php 
            echo $form->input('Phone.phone', array(
              'label' => 'Phone'. ': '
            ))."\n";
          ?>
          <?php
            echo $form->input('Phone.contactable', array(
              'label' => 'Yes, it\'s ok to call me at this number', 'type' => 'checkbox',
              'class' => 'checkbox', 'div' => false
            ))."\n";
          ?>
        </div>
      </fieldset>
      <fieldset>
      	<legend>Payment Information:</legend>
      	<div class="input_wrapper radio" id="card">
          <label for="amount" class="option_title"><strong>Card type: </strong><strong class="required">*</strong></label>
          <label class="option" id="mastercard"><input name="data[Card][type]" value="mastercard" class="radio" type="radio" <?php echo $common->creditCardSelected('mastercard'); ?>><span>mastercard</span></label>
          <label class="option" id="visa"><input name="data[Card][type]" value="visa" class="radio" type="radio" <?php echo $common->creditCardSelected('visa'); ?>><span>visa</span></label>
          <label class="option" id="visa_electron"><input name="data[Card][type]" value="visa_electron" class="radio" type="radio" <?php echo $common->creditCardSelected('visa_electron'); ?>><span>visa electron</span></label>
          <label class="option" id="diners_club"><input name="data[Card][type]" value="diners_club" class="radio" type="radio" <?php echo $common->creditCardSelected('diners_club'); ?>><span>diners club</span></label>
        </div>
        <div class="input_wrapper">
          <?php
            echo $form->input('Card.number', array(
              'label' => 'Card number'. ': ' . "<strong class='required'>*</strong>", 
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper" id="expire">
        	<label><strong>Expiracy date</strong> <strong class='required'>*</strong></label>
        	<div>
        	<?php 
		        echo $form->input('Card.expire_month', array(
		          'label' => '',
		          'options' => $monthOptions,
		        ))."\n";
        	?>
        	<?php 
		        echo $form->input('Card.expire_year', array(
		          'label' => '',
		          'options' => $yearOptions,
		        ))."\n";
        	?>
        	</div>
        </div>
        <div class="input_wrapper">
          <?php
            echo $form->input('Card.verification_code', array(
              'label' => 'Verification code'. ': ' . "<strong class='required'>*</strong>", 
            ))."\n";
          ?>
        </div>
      </fieldset>
      <?php echo $form->end('Donate'); ?>
    </div>
  </div>
  <div class="clear"></div>
  <div id="footer">
    <ul class="links">
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/privacy">Privacy</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/contactus">Contact</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/sitemap">Site Map</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/about/faq">FAQs</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/about/jobs">Jobs</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/copyright2" class="page">Copyright</a></li>
      <li><a href="<?php echo Configure::read("App.mirrorDomain"); ?>/footer/rss" class="page">RSS</a></li>
      <li class="last"><a href="http://feeds.feedburner.com/GreenpeaceNews" class="rss" id="">&nbsp</a></li>
    </ul>
  </div>