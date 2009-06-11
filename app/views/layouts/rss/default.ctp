<?php
echo $rss->header();

if (!isset($channel)) {
	$channel = array();
}
if (!isset($channel['title'])) {
	$channel['title'] = Configure::read('App.name') . ' Feed';
}

echo $rss->document(
	$rss->channel(
		array(), $channel, $content_for_layout
	)
);

?>