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
<?php echo $this->element('../templates/default/elements/mission'); ?>
<?php echo $this->element('../templates/default/elements/feedback'); ?>
      <?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
<?php	echo $this->element('../templates/default/elements/gift'); ?>
<?php echo $this->element('../templates/default/elements/decoration1'); ?>
<?php	echo $this->element('../templates/default/elements/contact'); ?>
<?php	echo $this->element('../templates/default/elements/payment'); ?>
<?php	echo $this->element('../templates/default/elements/smallprints'); ?>
<?php	echo $this->element('../templates/default/elements/security_notice'); ?>
      <?php echo $form->end(__('Donate',true)); ?>
    </div>
  </div>
<?php echo $this->element('../templates/default/elements/footer'); ?>