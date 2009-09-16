<div class="w_block">
	<div class="w_inner">
		<div class="landing_page">
			<h1><?php echo $this->pageTitle = 'Account activated'; ?></h1>
			<p>
				<?php
				echo sprintf(__('Hello <em>%s</em>, your account was <strong>successfully activated</strong>! You are <strong>logged in now</strong>! Please go ahead and change your password now.', true), User::name());
				?>
			</p>
		</div>
	</div>
</div>