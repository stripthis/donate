    <div id="posts" class="landing_page">
      <h2><?php echo __("Latest News"); ?></h2>
<?php if(isset($posts) && !empty($posts)): ?>
<?php foreach($posts as $post): ?>
      <div class="post">
        <h3><?php echo $post["title"]; ?></h3>
        <p><small><?php echo $post["pubDate"]; ?></small></p>
        <?php echo $post["description"]; ?>
      </div>
<?php endforeach; ?>
<?php else: ?>
			<div class="message"><?php echo __("Sorry, there is nothing to show there"); ?>...</div>
<?php endif; ?>
    </div>
