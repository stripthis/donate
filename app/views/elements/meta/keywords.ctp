<?php
if (!isset($keywords)) {
	$keywords = "green, greenpeace, climate change, energy revolution, donate, support, support us";
} elseif (is_array($keywords)) {
	$keywords = implode(", ", $keywords);
}
?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
