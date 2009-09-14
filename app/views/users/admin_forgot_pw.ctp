<?php if (!isset($tabindex)) $tabindex = 1; ?>   
  <div class="content forgot_pw">
    <h2>Forgot your Password?</h2>	
    <?php
	    echo $this->element('nav', array(
	    	'type' => 'admin_auth_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	    ));
	  ?>
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
