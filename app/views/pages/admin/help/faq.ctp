<div class="content help" id="admin_help_start">
	<h2><?php echo __('Help', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_help_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<ul class="faq">
		<li>
			<h3><?php __('Payment Processing'); ?></h3>
		</li>
		<li>
			<a href="#" class="toggle closed" id="toggle_faq1">
				1. <?php __('What is the redirect model?'); ?>
			</a>
			<p class="wrapper_toggle_faq1">
				<?php __('The redirect model is the one currently in use by GPI.'); ?>
			</p>
		</li>
		<li>
			<a href="#" class="toggle closed" id="toggle_faq2">
				2. <?php __('What is the redirect model?'); ?>
			</a>
			<p class="wrapper_toggle_faq2">
				<?php __('The redirect model is the one currently in use by GPI.'); ?>
			</p>
		</li>
		<li>
			<a href="#" class="toggle closed" id="toggle_faq3">
				3. <?php __('What are PCI DSS standards?'); ?>
			</a>
			<p class="wrapper_toggle_faq3">
				<?php __('Comming soon...'); ?>
			</p>
		</li>
		<li>
			<a href="#" class="toggle closed" id="toggle_faq4">
				4. <?php __('Which PCI DSS standards apply to my office?'); ?>
			</a>
			<p class="wrapper_toggle_faq4">
				<?php __('Comming soon...'); ?>
			</p>
		</li>
	</ul>
</div>
