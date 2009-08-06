<?php
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
	
	if (!empty($cData)) {
	  $cData = $cData['Gift'];
	}
?>
  <div id="content_wrapper">
    <div id="banner">
      <h1>Greenpeace - Support Us</h1>
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
      <?php echo $form->create('Gift', array('url' => $this->here)); ?>
      <fieldset class="left" id="gift_type">
        <legend><?php echo __("Gift Information"); ?></legend>
        <div class="input_wrapper radio">
          <label for="amount" class="option_title"><strong>Amount: </strong><strong class="required">*</strong></label>
          <label class="option"><input name="data[gift][amount]" value="5" class="radio" type="radio"> 5€</label>
          <label class="option"><input name="data[gift][amount]" value="10" class="radio" type="radio"> 10€</label>
          <label class="option"><input name="data[gift][amount]" value="15" class="radio" type="radio"> 15€</label>
        </div>
        <div class="input_wrapper radio" id="other_amount">
          <label class="option">
            <input name="data[gift][amount]" value="other" class="form-radio" type="radio" > Other
          </label>
          <input name="data[gift][amount_other]" type="text" class="text" id="txtOtherAmount"/> 
          <?php
            $currency= $cookie->read('currency');
            echo $form->input('currency', array(
              'label' => '', 'options' => $currencyOptions,
              'selected' => !empty($currency) ? $currency : ''
            ))."\n";
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
      <fieldset>
        <legend><?php echo __("Contact Information"); ?></legend>
        <div class="input_wrapper">
          <?php
            $salutation = $cookie->read('salutation');
            echo $form->input('salutation', array(
              'label' => 'Salutation:', 'options' => $saluteOptions,
              'selected' => !empty($salutation) ? $salutation : ''
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
            $fname = $cookie->read('fname');
            echo $form->input('fname', array(
              'label' => 'First Name'. ': ' . "<strong class='required'>*</strong>",
              'value' => !empty($fname) ? $fname : ''
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            $lname = $cookie->read('lname');
            echo $form->input('lname', array(
              'label' => 'Last Name'. ': ' . "<strong class='required'>*</strong>",
              'value' => !empty($lname) ? $lname : ''
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper full">
          <?php
            $address = $cookie->read('address');
            echo $form->input('address', array(
              'label' => 'Address'. ': ' . "<strong class='required'>*</strong>",
              'value' => !empty($address) ? $address : ''
            ))."\n";
          ?>
          <?php
            echo $form->input('address2', array(
              'label' => "",
              'value' => !empty($address2) ? $address2 : ''
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            $city = $cookie->read('city');
            echo $form->input('City', array(
              'label' => 'City'. ': ' . "<strong class='required'>*</strong>",
              'value' => !empty($city) ? $city : ''
            ))."\n";
          ?>
        </div>
        <div  class="input_wrapper half">
          <?php
          $zip = $cookie->read('zip');
          echo $form->input('zip', array(
            'label' => 'Zip Code'. ': ' . "<strong class='required'>*</strong>",
            'value' => !empty($zip) ? $zip : ''
          ))."\n";
          ?>
        </div>
        <div class="input_wrapper">
          <?php 
            $countryId = $cookie->read('country_id');
            echo $form->input('country_id', array(
              'label' => 'Country'. ': ' . "<strong class='required'>*</strong>", 'options' => $countryOptions,
              'selected' => !empty($countryId) ? $countryId : ''
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php 
            $email = $cookie->read('email');
            echo $form->input('email', array(
              'label' => 'Email'. ': ' . "<strong class='required'>*</strong>",
              'value' => !empty($email) ? $email : ''
            ));
          ?>
          <?php
            echo $form->input('allow_newsletter', array(
              'label' => 'I want to receive the newsletter', 'type' => 'checkbox', 'class' => 'required checkbox', 'div' => false));
          ?>
        </div>
        <div class="input_wrapper half">
          <?php 
            $email = $cookie->read('phone');
            echo $form->input('phone', array(
              'label' => 'Phone'. ': ',
              'value' => !empty($phone) ? $phone : ''
            ));
          ?>
          <?php
            echo $form->input('allow_phone', array(
              'label' => 'It\'s ok to contact me at this number', 'type' => 'checkbox', 'class' => 'required checkbox', 'div' => false));
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