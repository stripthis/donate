<?php header("HTTP/1.0 500 Internal Server Error"); ?>
<div class="w_block">
	<div class="w_inner">
		<div class="landing_page">
			<h1><?php echo $this->pageTitle = '500 - Internal Error occured'; ?></h1>
		</div>
		<p><?php echo __('Sorry, but something must have gone wrong in the internal workings of this application.', true); ?></p>
		<p>If you continue to experience this error, please <?php echo $html->link('contact us', array('controller' => 'pages', 'action' => 'view', 'contact')) ?>.</p>
	</div>
</div>