<?php
$title = $action == 'add'
	? __('New Office', true)
	: __('Edit Office Configuration', true);
?>
<div class="content" id="office_config_view">
	<h2><?php echo $title;?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_config_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
		));
	?>
	<?php echo $this->element('../offices/elements/actions'); ?>
	<?php echo $form->create('Office');?>
	<fieldset>
		<legend><?php sprintf(__('Main Preferences', true)); ?></legend>
		<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('live');
		echo $form->input('external_url', array('label' => 'If not live, url to redirect to'));
		echo $form->input('languages', array(
			'options' => Configure::read('App.lang_options'),
			'selected' => explode(',', $form->data['Office']['languages']),
			'multiple' => 'checkbox',
			'label' => 'Languages:'
		));
		?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Default Gift'); ?></legend>
		<?php
		echo $form->input('frequencies', array(
			'label' => '', 
			'options' => Gift::find('frequencies', array('options' => true)), 
			'multiple' => 'checkbox',
			'selected' => explode(',', $form->data['Office']['frequencies'])
		));

		echo $form->input('amounts', array(
			'value' => $form->data['Office']['amounts'], 'label' => 'Possible Amount Selections:'
		));
		?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Gateways & Currencies'); ?></legend>
		<?php
		echo $form->input('gateways', array(
			'options' => $gatewayOptions,
			'selected' => $selectedGateways, 
			'multiple' => 'checkbox'
		));

		$options = Configure::read('App.currency_options');
		$options = array_combine($options, $options);
		echo $form->input('currencies', array(
			'options' => $options,
			'selected' => explode(',', $form->data['Office']['currencies']),
			'multiple' => 'checkbox',
			'label' => 'Currencies:'
		));
		?>
	</fieldset>
	<?php echo $form->end('Save');?>
</div>