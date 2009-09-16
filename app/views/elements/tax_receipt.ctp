<?php if(Configure::read('App.Tax_receipt.enabled')): ?>
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
<?php endif; ?>