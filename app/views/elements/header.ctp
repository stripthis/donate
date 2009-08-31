<?php if (User::isGuest()) : ?>
    <div id="login">
    		<?php echo $html->link(__("Register",true),"/register",array("class"=>"register"))."\n"; ?>
        <form id="QuickLoginForm" method="post" action="/auth/login">
          <label for="UserPassword"><?php __("coming back?"); ?></label>
          <div class="input text"><input name="data[User][login]" maxlength="50" value="" id="UserLogin2" type="text" class="hint" title="your email">&nbsp;</div>
          <div class="input password required"></label><input name="data[User][password]"  value="" id="UserPassword2" type="password" class="hint" title="password"></div>
          <div class="submit"><input value="<?php echo __("login"); ?>" type="submit"></div>
        </form>
        <a href="/login#help" class="more" alt="<?php __("tell me more");?>">?</a>
<?php else : ?>
    <div id="current_user">
        <p><?php echo __("Hi"); ?> <strong> <?php echo h(User::get('name'))?></strong>:
          <?php echo $html->link(__('dashboard', true), array('controller' => 'users', 'action' => 'dashboard', 'admin' => false)); ?>  | 
          <?php echo $html->link(__('logout', true), array('controller' => 'auth', 'action' => 'logout', 'admin' => false)); ?></p>
<?php endif; ?>
    </div>
