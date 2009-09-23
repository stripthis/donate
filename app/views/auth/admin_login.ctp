<?php $this->pageTitle = 'Login'; ?>
<?php if (!isset($tabindex)) $tabindex = 1; ?>
<div id="admin_login" class="content">
	<h2><?php sprintf(__('Admin Login', true)); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_auth_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php echo $form->create('User', array('url' => '/admin/auth/login', 'id' => 'LoginForm'))."\n";?>
	<fieldset>
		<legend><?php sprintf(__('Please enter your login details', true)); ?></legend>
		<?php echo $form->input('login', array('label' => __('Email',true).':',"tabindex" => $tabindex++))."\n";?>
		<?php echo $form->input('password', array('label' => __('Password',true).':',"tabindex" => $tabindex++))."\n";?>
		<!-- @TODO
		<?php echo $form->input('password_gl3', array('label' => __('Global Password (GL3)',true).':',"tabindex" => $tabindex++))."\n";?>
		-->
		<div class="checkbox_wrapper">
			<label><input class="checkbox" type="checkbox" name="data[User][remember]" tabindex="<?php echo $tabindex++; ?>"/><span>Remember me on this computer</span></label>
			<p class="iconic info">(<a href="http://en.wikipedia.org/wiki/HTTP_cookie" target="_blank" alt="cookies are delicious delicacies">Cookies</a> need to be enabled...)</p>
		</div>
	</fieldset>
	<?php echo $form->submit(__('Login',true).' »',array("tabindex" => $tabindex++))."\n";?>
	<?php echo $form->end()."\n";?>
	<div class="clear"></div>
</div>