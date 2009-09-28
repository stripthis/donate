<?php header("HTTP/1.0 404 Not Found"); ?>
<div class="w_block">
	<div class="w_inner">
		<div class="landing_page">
			<h1><?php echo $this->pageTitle = '404 - Page not found'; ?></h1>
		</div>
		<p><?php echo __('We are sorry, but we could not locate the page you requested on the server.', true); ?></p>
	</div>
</div>