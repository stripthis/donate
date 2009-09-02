<?php if (!isset($tabindex)) $tabindex = 1; ?>   
  <div id="forgot_pw" class="landing_page">
    <h2>Forgot your Password?</h2>
    <div class='breadcrumb'>
      <?php echo __('You are here'); ?>: 
        <?php echo $html->link(__('Home',true),'/');?> » 
        <?php echo $html->link(__('Member login',true),'/admin/auth/login');?> » 
        <?php echo __('Lost Password')."\n"; ?>
    </div>
 <?php echo $this->element('messages'); ?>
    <?php echo $form->create('User', array('action' => 'forgot_pw')); ?>
    <fieldset>
      <legend><?php echo __("Password recovery"); ?></legend>
      <?php echo $form->input('login', array('label' => 'Email:','tabindex' => $tabindex++));?>
    </fieldset>
    <?php echo $form->submit(__('Recover Password',true)." »",array("tabindex"=>$tabindex++));?>
    <?php echo $form->end()?>
    <div class='clear'></div>
  </div>
