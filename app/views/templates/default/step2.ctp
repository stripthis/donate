<?php
$this->pageTitle = "Support Us | Greenpeace International (Multistep Form Example)";
$saluteOptions = array('ms' => 'Ms.', 'mrs' => 'Mrs.', 'mr' => 'Mr.');
$titleOptions = array(
	'dr' => 'Dr.',
	'drdr' => 'Dr. Dr.',
	'prof' => 'Prof.',
	'profdr' => 'Prof. Dr.',
	'profdrdr' => 'Prof. Dr. Dr.',
	'dipl' => 'Dipl.'
);
$currencyOptions = Gift::find('currencies');
$frequencyOptions = Gift::find('frequencies');

if (!empty($cData)) {
	$cData = $cData['Gift'];
}
?>
<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
	<div id="content">
<?php echo $this->element('../templates/default/elements/title'); ?>
<?php echo $this->element('../templates/default/elements/mission'); ?>
<?php echo $this->element('../templates/default/elements/feedback'); ?>
		<?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
		<?php echo $form->create('Gift', array('url' => $this->here . '/2'))."\n"; ?>
		<?php echo $form->input( 'Gift.id', array('type' => 'hidden'))."\n"; ?>
		<?php echo $form->input( 'Gift.type', array('type' => 'hidden', "value" => "donation"))."\n"; ?>
		<?php echo $form->input( 'Gift.appeal_id', array('type' => 'hidden'))."\n"; ?>
		<?php echo $this->element('../templates/default/contact'); ?>
		<?php echo $form->submit('Donate', array('class' => 'donate-submit')); ?>
		<?php echo $form->end()?>
	</div>
</div>
<?php echo $this->element('../templates/default/elements/footer')?>