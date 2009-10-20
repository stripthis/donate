<?php
if(!isset($twitter_posts) || empty($twitter_posts)) {
	$posts = $this->requestAction("/posts/index/twitter");
}
?>
<div id="twitter_feed" class="widget">
	<h3><a href="<?php echo Router::Url(null,true); ?>" class="toggle open" id="toggle_twitter_feed"><?php echo __('Latest Tweets', true); ?></a></h3>
	<a href="<?php echo Configure::read("App.twitterFeed"); ?>" target="_blank" class="rss"><span class="hidden">rss</span></a>
	<div class="widget_content toggle_wrapper" id="wrapper_toggle_twitter_feed">
		<ul class="posts">
			<?php
			$count = count($posts);
			?>
			<?php for ($k = 0; ($k < $count && $k <= 2); $k++): ?>
				<li>
					<p>
						<strong><?php echo date("d/m/Y @ h:i",strtotime($posts[$k]["pubDate"])); ?></strong>
						<?php echo $posts[$k]["title"]; ?>
					</p>
				</li>
			<?php endfor; ?>
			<li class="last">
				<a href="<?php echo Configure::read("App.twitterURL"); ?>" rel="nofollow" target="_blank"><?php echo __('follow us on twitter', true); ?>&raquo;</a>
			</li>
		</ul>
	</div>
</div>