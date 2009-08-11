<h1>Thanks!</h1>
<p>Thank you for your gift! It is appreciated!</p>

<h2>Your Receipts</h2>
<p>Here is a list of receipts of all the gifts you made in this browser session so far.</p>

<ul>
	<?php
	$authKeys = $session->read('gift_auth_keys');
	?>
	<?php foreach ($authKeys as $i => $keyData) : ?>
		<?php
		$url = array(
			'controller' => 'gifts', 'action' => 'receipt',
			$keyData['key'] . '/' . $keyData['foreign_id'],
			'user_id' => $keyData['user_id'],
			'auth_key_type_id' => $keyData['auth_key_type_id'],
		);
		?>
		<li><?php echo $html->link('Receipt #' . ++$i, $url)?></li>
	<?php endforeach; ?>
</ul>

<h2>Way To Go</h2>
<ul>
	<li>
		<?php echo $html->link('Add Another Gift', array('controller' => 'gifts', 'action' => 'add'))?>
	</li>
	<li>
		<?php echo $html->link('Tell Your Friends!', array('controller' => 'tell_friends', 'action' => 'add'))?>
	</li>
</ul>
	