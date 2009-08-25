<?php if(!isset($tabindex)) $tabindex = 1; ?>   
    <div id="resend_activation" class="landing_page">
      <h2><?php __("Resend Activation Email"); ?></h2>
      <div class='breadcrumb'>
        <?php echo __('You are here'); ?>: 
          <?php echo $html->link(__('Home',true),'/');?> » 
          <?php echo $html->link(__('member login',true),'/login');?> » 
          <?php echo __('resend actication email')."\n"; ?>
      </div>
	  <?php echo $this->element('messages'); ?>
      <?php echo $form->create('User', array('action' => 'resend_activation_email')); ?>
      <fieldset>
        <legend><?php echo __("Password recovery"); ?></legend>
        <?php echo $form->input('login', array('label' => __('Email',true)." :",'tabindex' => $tabindex++));?>
      </fieldset>
      <?php echo $form->submit(__('Resend',true)." »",array("tabindex"=>$tabindex++));?>
      <?php echo $form->end()?>
      <div class='clear'></div>
    </div>
