<?php
$base = 'img/icons/S/';
if (!isset($uri)) {
	switch ($model) {
		case 'Contact': // completeness
			if (!isset($status) || !$status) {
				$status = 'error';
			} elseif ($status === true || $status > 0) {
				$status = 'tick';
			}
		break;
		case 'Gift':
		default:
			if (!isset($status) || !$status) {
				$status = 'error';
			}
		break;
	}
	$uri = $base . $status . '.png';
}

?>
<td class="status"><img src="<?php echo $uri; ?>" alt="<?php echo $status; ?>" title="<?php echo $status; ?>"/></td>