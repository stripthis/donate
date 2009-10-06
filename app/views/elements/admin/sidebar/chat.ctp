<?php
$open = (!isset($options['open'])) ? 'close' : $options['open'];
?>
<div class="chats widget">
	<div class="widget_header">
		<h3>
			<a href="<?php Router::url(); ?>#" class="toggle <?php echo $open; ?>" id="toggle_chat">
				<?php echo __('Chat', true); ?>
			</a>
		</h3>
	</div>
	<div class="widget_content">
		<?php echo $ajaxChat->generate(1)?>
	</div>
</div>
