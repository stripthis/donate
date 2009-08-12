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
      <?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
      <?php echo $form->input( 'Gift.id', array('type' => 'hidden'))."\n"; ?>
      <?php echo $form->input( 'Gift.type', array('type' => 'hidden', "value" => "donation"))."\n"; ?>
      <?php echo $form->input( 'Gift.appeal_id', array('type' => 'hidden'))."\n"; ?>
      <fieldset class="left" id="gift_type">
        <legend><?php echo __("Gift Information"); ?></legend>
        <div class="input_wrapper radio">
		<?php
		$amount = $giftForm->value('Gift', 'amount', '10', $form->data);
		$checked = 'checked="checked"';
		$nonChecked = 'checked=""';
		?>
		<label for="amount" class="option_title"><strong>Amount: </strong><strong class="required">*</strong></label>
		<label class="option">
			<input 
				name="data[Gift][amount]" value="5" class="radio amount" type="radio" 
				<?php echo $amount == 5 ? $checked : ''?>> 5€
		</label>
		<label class="option">
			<input name="data[Gift][amount]" value="10" class="radio amount" type="radio" 
			<?php echo $amount == 10 ? $checked : ''?>> 10€
		</label>
		<label class="option">
			<input name="data[Gift][amount]" value="15" class="radio amount" type="radio" 
			<?php echo $amount == 15 ? $checked : ''?>> 15€</label>
        </div>
        <div class="input_wrapper radio" id="other_amount">
          <label class="option">
            <input name="data[Gift][amount]" value="other" class="form-radio otheramount" type="radio"> Other
          </label>
          <input name="data[Gift][amount_other]" type="text" class="text" id="txtOtherAmount" 
			value="<?php echo !in_array($amount, array(5, 10, 15)) ? $amount : ''?>"
			<?php echo !in_array($amount, array(5, 10, 15)) ? $checked : ''?> 
	      /> 
          <?php
            echo $form->input('currency', array(
              'label' => '', 'options' => $currencyOptions,
              'selected' => $giftForm->value('Gift', 'currency', '', $form->data)
            ))."\n";
          ?>
          <?php 
          	if($form->isFieldError('amount')) {
          		echo '<div class="error">' . $form->error("Gift.amount") . '</div>';
          	}
          	if($form->isFieldError('currency')) {
          		echo '<div class="error">' . $form->error("Gift.currency"). '</div>';
          	}
          ?>
        </div>
		<?php
		$options = array(
			'label' => 'Frequency'. ': ' . $required,
			'options' => $frequencyOptions,
			'selected' => $giftForm->value('Gift', 'frequency', 'monthly', $form->data)
        );
        echo $form->input('frequency', $options);
		?>
      </fieldset>
      <div class="form_decoration half left" id="activist">
        <p>
          &#x201c; Greenpeace exists because this fragile Earth deserves a voice. 
          It needs solutions. It needs change. It needs action. &#x201d;
        </p>
      </div>
      <div class="spacer"></div>
      <?php echo $form->end('Proceed to Step 2'); ?>
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