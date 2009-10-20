<?php
if (!isset($posts) || empty($posts)) {
	return;
}
?>
<div class="widget news <?php echo $open ?>">
	<div class="widget_header">
		<h3><a href="<?php Router::url(); ?>#" class="toggle <?php echo $open ?>" id="toggle_news"><?php echo __('News', true); ?></a></h3>
	</div>
	<div class="widget_content">
		<ul class="wrapper_toggle_news">
			<li class="news">
				<h4 class="title"><a href="<?php echo $posts[0]["link"]; ?>" target="_blank"><?php echo $posts[0]["title"]; ?></a></h4>
				<p class="date"><em><?php echo date("d/m/Y @ h:i",strtotime($posts[0]["pubDate"])); ?></em></p>
				<p class="body">
					<?php echo $text->truncate(strip_tags($posts[0]["description"]),150,'...',false); ?>
					<a href="<?php echo $posts[0]["link"]; ?>" target="_blank"><?php echo __('more', true)." »"; ?></a>
				</p>
			</li>
		</ul>
	</div>
</div>