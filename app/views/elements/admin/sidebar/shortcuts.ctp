<?php
	$open = (!isset($options['open'])) ? 'close' : $options['open']; // widget is closed by default
?>
    <div class="shortcuts widget">
    	<div class="widget_header">
 			  <h3><a href="<?php Router::url(); ?>#" class="toggle <?php echo $open ?>" id="toggle_shortcuts"><?php echo __('Shortcuts'); ?></a></h3>
      </div>
      <div class="widget_content">
        <ul class="wrapper_toggle_shortcuts">
          <li><a href="javascript:addFavorite()" class="iconic bookmark"><?php echo __('Bookmark this page'); ?></a></li>
          <li><a href="javascript:printThis()" class="iconic print"><?php echo __('Print this page'); ?></a></li>
          <li><a href="#" class="iconic increaseFont"><?php echo __('Increase font size'); ?></a></li>
          <li><a href="#" class="iconic decreaseFont"><?php echo __('Decrease font size'); ?></a></li>
        </ul>
      </div>
    </div>
