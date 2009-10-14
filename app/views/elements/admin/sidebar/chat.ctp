<div class="chat widget <?php echo $open ?>">
	<div class="widget_header">
		<h3>
			<a href="<?php Router::url(); ?>#" class="toggle <?php echo $open; ?>" id="toggle_chat">
				<?php echo __('Chat', true); ?>
			</a>
		</h3>
	</div>
	<div class="widget_content">
		<div class="wrapper_toggle_chat">
			<?php echo $ajaxChat->generate(1)?>
		</div>
	</div>
</div>