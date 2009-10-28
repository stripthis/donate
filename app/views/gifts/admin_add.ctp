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
	<fieldset class="gift" id="gift_type">
		<legend><?php echo __("Gift Information"); ?></legend>
		<?php
		echo $form->input('Gift.type', array('options' => Gift::find('gift_types')));
		echo $form->input('Gift.amount', array('label' => 'Amount:'));
		echo $form->input('Gift.appeal_id', array('options' => $appealOptions));
		echo $form->input('currency', array('label' => '', 'options' => Gift::find('currencies')));
		echo $form->input('frequency_id', array(
			'label' => 'Frequency' . ': ' . $giftForm->required(),
			'options' => Gift::find('frequencies')
		));
		echo $form->input('Gift.contact_id', array('type' => 'hidden', 'value' => $contact['Contact']['id']));
		?>
	</fieldset>
	<div class="clear"></div>
	<?php echo $form->submit('Save', array('class' => 'donate-submit')); ?>
	<?php echo $form->end(); ?>
</div>