<?php
	$base = 'img/icons/S/';
	if(isset($status) && !isset($uri)){
		$uri = $base . $status . '.png';
	}elseif(!isset($status) && !isset($uri)){
		$uri = $base . 'stop' . '.png';
	}
?>
            <td class="status">
            		<img src="<?php echo $uri; ?>" alt="<?php echo $status; ?>" title="<?php echo $status; ?>"/>
            </td>
