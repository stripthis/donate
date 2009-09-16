<?php
  $this->pageTitle = "Add Donation";
  $titleOptions = '';
?>
  <div id="content_wrapper">
    <div id="banner">
      <h1><?php echo $this->pageTitle; ?></h1>
    </div>
    <div id="content">
      <p class="message information">Hint: <strong class="required">*</strong> indicates a required field</p>
<?php foreach ($flashMessages as $message): ?>
      <p class="message <?php echo $message['type']; ?>"><?php echo $simpleTextile->toHtml($message['text']); ?></p>
<?php endforeach; ?>
      <?php echo $form->create('Gift', array('url' => $this->here))."\n"; ?>
<?php echo $this->element('../templates/default/gift'); ?>
      <div class="form_decoration half left" id="activist">
      </div>
      <div class="spacer"></div>
<?php echo $this->element('../templates/default/contact'); ?>
<?php	echo $this->element('../templates/default/payment'); ?>
     	<?php echo $form->submit('Donate', array('class' => 'donate-submit')); ?>
		<?php echo $form->end(); ?>
    </div>
  </div>