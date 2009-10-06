<?php
	$this->pageTitle = "Support Us | Greenpeace International (Multistep Form Example - Step 2)";
	$saluteOptions = Contact::getSalutations();
	$titleOptions = Contact::getTitles();
	$frequencyOptions = Gift::find('frequencies');
	$currencyOptions = Gift::find('currencies');
	if (!empty($cData)) {
	  $cData = $cData['Gift'];
	}
?>
  <div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
     <div id="content">
<?php echo $this->element('../templates/default/elements/title'); ?>
<?php echo $this->element('../templates/default/elements/teasers/mission'); ?>
<?php echo $this->element('../templates/default/elements/feedback'); ?>
      <?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
<?php	echo $this->element('../templates/default/elements/gift'); ?>
<?php echo $this->element('../templates/default/elements/teasers/decoration1'); ?>
      <?php echo $form->end(__('Proceed to Step 2',true)); ?>
    </div>
  </div>
<?php echo $this->element('../templates/default/elements/footer') ?>