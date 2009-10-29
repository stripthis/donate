<?php
$this->pageTitle = "Support Us | Greenpeace International (Multistep Form Example - Step 2)";

if (!empty($cData)) {
	$cData = $cData['Gift'];
}
?>
	<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
		<div id="content">
<?php echo $this->element('../templates/default/elements/teasers/title1'); ?>
<?php echo $this->element('../templates/default/elements/teasers/mission1'); ?>
<?php echo $this->element('../templates/default/elements/feedback'); ?>
		<?php echo $form->create('Gift', array('url' => $this->here . '/2'))."\n"; ?>
<?php echo $this->element('../templates/default/elements/fieldsets/hidden'); ?>
<?php echo $this->element('../templates/default/elements/fieldsets/contact'); ?>
<?php //echo $this->element('../templates/default/elements/fieldsets/smallprints'); ?>
		<?php echo $form->submit('Donate', array('class' => 'donate-submit')); ?>
		<?php echo $form->end()?>
		</div>
	</div>
<?php echo $this->element('../templates/default/elements/footer')?>