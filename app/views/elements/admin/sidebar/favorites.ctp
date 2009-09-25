<?php
	// @todo display number of favorites next the the link, ex: Gifts (0) - session stores only id, not object types
	$favorites = $session->read('favorites');
	$open = (!isset($options['open'])) ? 'close' : $options['open']; // widget is closed by default
?>
    <div class="favorites widget">
    	<div class="widget_header">
 			  <h3>
 			    <a href="<?php Router::url(); ?>#" class="toggle <?php echo $open; ?>" id="toggle_favorites"><?php echo __('Favorites', true); ?>
 			    <small>(<?php echo count($favorites); ?>)</small></a>
 			  </h3>
      </div>
      <div class="widget_content">
        <ul class="wrapper_toggle_favorites with_bullets">
          <li><a href="admin/gifts/index/favorites" class=""><?php echo __('Gifts', true); ?></a></li>
          <?php /* TODO supporters
          <li><a href="admin/supporters/index/favorites" class=""><?php echo __('Supporters'); ?></a></li>
          */ ?>
          <li><a href="admin/transactions/index/favorites" class=""><?php echo __('Transactions', true); ?></a></li>
        </ul>
      </div>
    </div>
