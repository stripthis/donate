<div class="shortcuts widget <?php echo $open ?>">
	<div class="widget_header">
		<h3><a href="<?php Router::url(); ?>#" class="toggle <?php echo $open ?>" id="toggle_shortcuts"><?php echo __('Shortcuts', true); ?></a></h3>
	</div>
	<div class="widget_content">
		<ul class="wrapper_toggle_shortcuts">
			<li><a href="javascript:addFavorite()" class="iconic bookmark"><?php echo __('Bookmark this page', true); ?></a></li>
			<li><a href="javascript:printThis()" class="iconic print"><?php echo __('Don\'t print this page', true); ?></a></li>
			<li><a href="#" class="iconic increaseFont"><?php echo __('Increase font size', true); ?></a></li>
			<li><a href="#" class="iconic decreaseFont"><?php echo __('Decrease font size', true); ?></a></li>
		</ul>
	</div>
</div>