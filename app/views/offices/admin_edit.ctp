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
		<legend><?php echo __('Main Preferences', true); ?></legend>
		<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('live');
		echo $form->input('external_url', array('label' => 'If not live, url to redirect to'));

		$selected = array();
		if ($action == 'edit') {
			$selected = Set::extract('/LanguagesOffice/language_id', $office);
		}
		echo $form->input('languages', array(
			'options' => $languageOptions,
			'selected' => $selected,
			'multiple' => 'checkbox',
			'label' => 'Languages:'
		));
		?>
	</fieldset>
	<fieldset>
		<?php
		$selected = array();
		if ($action == 'edit') {
			$selected = Set::extract('/FrequenciesOffice/frequency_id', $office);
		}
		echo $form->input('frequencies', array(
			'options' => $frequencyOptions,
			'label' => __('Possible Frequencies', true),
			'multiple' => 'checkbox',
			'selected' => $selected
		));

		echo $form->input('amounts', array(
			'value' => $form->data['Office']['amounts'], 'label' => 'Possible Amount Selections:'
		));
		?>
	</fieldset>
	<fieldset>
		<legend><?php echo __('Gateways & Currencies', true); ?></legend>
		<?php
		$selected = array();
		if ($action == 'edit') {
			$selected = Set::extract('/GatewaysOffice/gateway_id', $office);
		}
		echo $form->input('gateways', array(
			'options' => $gatewayOptions,
			'selected' => $selected,
			'multiple' => 'checkbox'
		));

		$options = Configure::read('App.gift.currencies');
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