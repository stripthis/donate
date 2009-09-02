<?php $this->pageTitle = 'Login'; ?>
<?php if(!isset($tabindex)) $tabindex = 1; ?>
  	<div id="admin_login" class="content">
      <h2><?php echo __("Sign in"); ?></h2>
      <cake:nocache>
<?php echo $this->element('messages'); ?>
      </cake:nocache>
      <?php echo $form->create('User', array('url' => '/admin/auth/login', 'id' => 'LoginForm'))."\n";?>
        <fieldset>
          <legend><?php echo __("Please enter your login details"); ?></legend>
          <?php echo $form->input('login', array('label' => __('Email',true).':',"tabindex" => $tabindex++))."\n";?>
          <?php echo $form->input('password', array('label' => __('Password',true).':',"tabindex" => $tabindex++))."\n";?>
          <div class="checkbox_wrapper">
            <label><input class="checkbox" type="checkbox" name="data[User][remember]" tabindex="<?php echo $tabindex++; ?>"/><span>Remember me on this computer</span></label>
            <p>(<a href="http://en.wikipedia.org/wiki/HTTP_cookie" target="_blank" alt="cookies are delicious delicacies">Cookies</a> need to be enabled...)</p>
          </div>
        </fieldset>
      <?php echo $form->submit(__('Login',true).' »',array("tabindex" => $tabindex++))."\n";?>
      <?php echo $form->end()."\n";?>
      <div class="clear"></div>
	<p><?php echo $html->link('I forgot my password!', array('controller' => 'users', 'action' => 'forgot_pw'))?></p>
    </div>