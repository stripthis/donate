<?php
if (!isset($messages) || empty($messages)) {
	echo '<p>' . __('No Messages', true) . '</p>';
	return;
}

foreach ($messages as $i => $message) {
	$class = ($i % 2 == 0) ? 'odd' : 'even';
	echo sprintf('<p class="%s"><strong>%s (%s):</strong> %s</p>',
		$class, $message['User']['name'],
		$time->timeAgoInWords($message['Chat']['created']),
		$smiley->parse(nl2br($message['Chat']['message']), $smileys)
	);
}
?>