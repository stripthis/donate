Welcome to <?php echo Configure::read('App.name') ?>!
<?php echo "\n\n"; ?>
Hey! Thanks for signing up for a free account with us. In order for us to ensure that only users with a valid email address register, please click the activation link below. Once you have clicked it, you are automatically logged in.
<?php echo "\n\n"; ?>
<?php echo Router::url('/users/activate/'.$id.'/auth_key:'.$authKey, true); ?>
<?php echo "\n\n"; ?>
Okay, now have fun with the game!
<?php echo "\n\n"; ?>
-- Your <?php echo Configure::read('App.name') ?> Team