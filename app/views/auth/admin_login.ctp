<?php $this->pageTitle = 'Admin Login'; ?>
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
    </div>
    <div class="sidebar_wrapper" id="right">
     <div class="help">
       <h3><?php echo __("Need some help?"); ?></h3>
       <ul>
         <li> I bet you <a href="/users/forgot_pw" name="help" id="help">forgot your password</a>? </li>
         <li> Or you need some more <a href="http://www.youtube.com/watch?v=NfqL7bwx9fs" target="_blank" rel="nofollow">power?</a></li>
       </ul>
     </div>
     <div class="clear"></div>
  	</div>