<?php
  if(!isset($posts) || empty($posts)) {
	return;
  }
	$open = (!isset($options['open'])) ? 'close' : $options['open']; // widget is closed by default
?>
    <div class="widget news">
    	<div class="widget_header">
 			  <h3><a href="<?php Router::url(); ?>#" class="toggle <?php echo $open ?>" id="toggle_news"><?php echo __('News'); ?></a></h3>
      </div>
      <div class="widget_content">
        <ul class="wrapper_toggle_news">
          <li class="news">
            <h4 class="title"><a href="<?php echo $posts[0]["link"]; ?>" target="_blank"><?php echo $posts[0]["title"]; ?></a></h4>
            <p class="date"><em><?php echo date("d/m/Y @ h:i",strtotime($posts[0]["pubDate"])); ?></em></p>
            <p class="body">
              <?php echo $text->truncate(strip_tags($posts[0]["description"]),150,'...',false); ?>
              <a href="<?php echo $posts[0]["link"]; ?>" target="_blank"><?php echo __("more")." »"; ?></a>
            </p>
          </li>
          <li class="last">
            <a href="<?php echo $posts['feed']['link']; ?>" rel="nofollow" target="_blank"><?php echo __("follow us on Making Waves"); ?> »</a>
          </li>
        </ul>
      </div>
    </div>

<?php

?>
<?php if(isset($posts_news[0]) && !empty($posts_news[0])): ?>
    <div id="news_feed" class="widget">
      <h3><a href="<?php echo Router::Url(null,true); ?>" class="toggle open" id="toggle_news_feed"><?php echo __("Latest blog entry"); ?></a></h3>
      <a href="<?php echo Configure::read("App.newsFeed"); ?>" target="_blank" class="rss"><span class="hidden">rss</span></a>
      <div class="widget_content toggle_wrapper" id="wrapper_toggle_news_feed">
        <ul class="posts">

        </ul>
      </div>
    </div>
<?php endif; ?>
