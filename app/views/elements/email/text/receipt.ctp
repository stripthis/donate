Thank you for your support!

Please check your receipt online here:
<?php
$url = array(
	'controller' => 'gifts', 'action' => 'receipt',
	$keyData['key'] . '/' . $keyData['foreign_id'],
	'user_id' => $keyData['user_id'],
	'auth_key_type_id' => $keyData['auth_key_type_id'],
);
echo Router::url($url, true); ?>

Make sure to go there within the next three days or else the link expires for security reasons!

Thanks,

Your Greenpeace Team