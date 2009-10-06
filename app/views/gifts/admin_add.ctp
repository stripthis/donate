<div class="content view" id="gifts_view">
	<h2><?php echo __('New Gift', true);?></h2>
	<div class="actions">
		<h3><?php echo __('Actions', true); ?></h3>
		<ul>
			<li>
			<?php
			$name = $contact['Contact']['fname'] . ' ' . $contact['Contact']['lname'];
			$label = sprintf(__('Back to %s', true), $name);
			echo $html->link('&raquo ' . $label, array(
				'controller' => 'contacts', 'action' => 'view', $contact['Contact']['id']
			), null, false, false);
			?>
			</li>
		</ul>
	</div>
	<?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
	<?php echo $this->element('../templates/default/elements/gift', compact('appealOptions')); ?>
	<div class="clear"></div>
	<?php echo $this->element('../templates/default/elements/payment'); ?>
	<div class="clear"></div>
	<?php echo $form->submit('Save', array('class' => 'donate-submit')); ?>
	<?php echo $form->end(); ?>
</div>