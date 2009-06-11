<?php
if (empty($email)) {
	$email = isset($this->data['User']['login']) ? $this->data['User']['login'] : '';
}
$name = isset($this->data['User']['name']) ? $this->data['User']['name'] : '';
$city = isset($this->data['User']['city']) ? $this->data['User']['city'] : '';
?>
<?php if(!isset($tabindex)) $tabindex = 1; ?>   
    <div id='register' class='landing_page'>
      <h2><?php echo $this->pageTitle = __('New Registration',true); ?></h2>
      <div class="wizard">
        <ul>
          <li class="current"><strong class="step">1.</strong><span><?php echo __("Enter details"); ?></span></li>
          <li><strong class="step">2.</strong><span><?php echo __("Select CEOs"); ?></span></li>
          <li><strong  class="step">3.</strong><span><?php echo __("Profit!"); ?></span></li>
        </ul>
      </div>
      <div class='clear'></div>
      <?php echo $this->element('messages'); ?>
      <?php echo $form->create('User', array('action' => 'register', 'autocomplete' => 'off'))?>
        <fieldset>
          <legend class="login"><?php echo __("Your login"); ?></legend>
          <div class="input text required"><?php echo $form->input('User.login', array('label' => __('Email',true).' *','class'=>'input text required','tabindex' => $tabindex++,'div'=>false, 'value' => $email))?></div>
          <?php echo $form->input('User.password', array('label' => __('Password',true).' *',"tabindex" => $tabindex++))?>
          <?php echo $form->input('User.repeat_password', array('label' => __('Confirm password',true).' *', 'type' => 'password',"tabindex" => $tabindex++))?>
        </fieldset>
        <div class='clear'></div>
        <fieldset>
          <legend class="profile"><?php echo __("Your profile"); ?></legend>
          <?php echo $form->input('User.name', array('label' => __('Your Name (or nickname)',true).' *','class'=>'input text required','tabindex' => $tabindex++, 'value' => $name))?>
          <?php echo $form->input('User.country_id', array('label' => __('Country',true).' *', 'selected' => Country::getIdByName('United States'),"tabindex" => $tabindex++))?>
          <?php echo $form->input('User.state_id', array('label' => __('State',true), 'type' => 'select',"tabindex" => $tabindex++))?>
          <?php echo $form->input('User.city', array('label' => __('City',true),"tabindex" => $tabindex++, 'value' => $city))?>
        </fieldset>
        <fieldset>
          <legend class="legal"><?php echo __("Small prints"); ?></legend>
          <div class="checkbox_wrapper">
            <label>
              <?php echo $form->input('User.eula', array('label' => false, 'type' => 'checkbox', 'class' => 'required checkbox', 'div' => false, 'tabindex' => $tabindex++))?>
              <span class="terms"><?php echo __("I've read and accept the fascinating"); ?> <a href='http://www.greenpeace.org/international/campaigns/climate-change/cool-it-challenge/about/faq#community_guidelines' target="_blank"><?php echo __("Community Guidelines");?></a>.</span>
            </label>
            <div class="clear"></div>
            <p><?php __("Note: Greenpeace won't be selling or giving your information away. We only collect what is needed to contact you."); ?></p>
          </div>
          <script>
            var RecaptchaOptions = {
              theme : "clean",
              tabindex : <?php echo $tabindex++; ?>
            };
          </script>
          <?php
             App::import('Vendor', 'recaptchalib');
             $publickey = Configure::read('App.recaptcha_key');
             echo recaptcha_get_html($publickey);
          ?>
        </fieldset>
      <?php echo $form->submit(__('Register',true)." »",array("tabindex"=>$tabindex++));?>
      <?php echo $form->end()?>
      <div class='clear'></div>
    </div>
