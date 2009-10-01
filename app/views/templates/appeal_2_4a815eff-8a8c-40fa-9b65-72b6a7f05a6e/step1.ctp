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
	exit;
?>
  <div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
     <div id="content">
<?php echo $this->element('../templates/default/elements/title'); ?>
<?php echo $this->element('../templates/default/elements/mission'); ?>
<?php echo $this->element('../templates/default/elements/decoration1'); ?>
      <p class="message information"><?php __('Hint: <strong class="required">*</strong> indicates a required field',true);?></p>
<?php foreach ($flashMessages as $message): ?>
      <p class="message <?php echo $message['type']; ?>"><?php echo $simpleTextile->toHtml($message['text']); ?></p>
<?php endforeach; ?>
      <?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
<?php	echo $this->element('../templates/default/gift'); ?>
<?php echo $this->element('../templates/default/elements/decoration1'); ?>
      <?php echo $form->end(__('Proceed to Step 2',true)); ?>
    </div>
  </div>
  <div class="clear"></div>