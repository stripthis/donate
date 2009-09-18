<?php
if (!Configure::read('App.Tax_receipt.enabled')) {
	return;
}
?>
<ul>
<?php
$authKeys = $session->read('gift_auth_keys');
foreach ($authKeys as $i => $keyData) {
	$url = array(
		'controller' => 'gifts', 'action' => 'receipt',
		$keyData['key'] . '/' . $keyData['foreign_id'],
		'user_id' => $keyData['user_id'],
		'auth_key_type_id' => $keyData['auth_key_type_id'],
	);
	echo '<li>' . $html->link('Receipt #' . ++$i, $url) . '</li>';
}
?>
</ul>