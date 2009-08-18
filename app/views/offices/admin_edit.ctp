<div class="offices form">
  <h2><?php __('Edit Office');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Office.id')), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Office.id'))); ?></li>
</ul>
  </div>
<?php echo $form->create('Office');?>
<?php
echo $form->input('id');
echo $form->input('name');

$selected = !empty($office) ? $office['Office']['parent_id'] : false;
echo $form->input('parent_id', array(
	'label' => 'Parent Office', 'options' => $parentOptions,
	'empty' => '--', 'selected' => $selected
));

if (empty($subOptions)) {
	$subOptions[''] = 'No Options Available';
}
echo $form->input('suboffice_id', array(
	'label' => 'Sub Offices', 'options' => $subOptions, 'multiple' => true,
	'selected' => $selectedSubs
));

echo $form->input('frequencies', array(
	'label' => '', 'options' => Gift::find('frequencies', array('options' => true)), 'multiple' => true,
	'selected' => explode(',', $form->data['Office']['frequencies'])
));

echo $form->input('amounts', array(
	'value' => $form->data['Office']['amounts'], 'label' => 'Possible Amount Selections:'
));
?>

<fieldset><legend>Gateways</legend>
	<?php echo $form->input('Gateway'); ?>
</fieldset>

<?php echo $form->end('Save');?>
</div>