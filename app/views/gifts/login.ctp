<h1>Login</h1>

<?php
$loggedIn = User::get('login') != Configure::read('App.guestAccount');
?>

<?php if ($loggedIn) : ?>
	<p>We recognized you as <?php echo User::get('first_name')?> <?php echo User::get('first_name')?>.</p>
	<p>Please <?php echo $html->link('Proceed', array('controller' => 'gifts', 'action' => ''))?></p>
<?php else : ?>

<?php endif; ?>