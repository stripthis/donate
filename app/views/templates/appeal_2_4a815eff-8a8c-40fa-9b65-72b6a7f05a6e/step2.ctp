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
	<div id="banner">
		<h1><?php echo $this->pageTitle; ?></h1>
		<a href="http://www.greenpeace.org" alt="Greenpeace" class="greenpeace"><span>Greenpeace</span></a>
		<a href="http://localdonate.com" alt="Greenpeace" class="donate"><span>Support Us</span></a>
	</div>
	<div id="content">
		<h1>Support Greenpeace International</h1>
		<p class="mission">
			Greenpeace relies on donations from generous individuals to carry out our work.<br/>
		In order to remain independent, we do not accept funding from governments, corporations or political parties.
		<strong>We can't do it without your help.</strong>
		</p>
		<p class="message information">Hint: <strong class="required">*</strong> indicates a required field</p>

		<?php foreach ($flashMessages as $message): ?>
			<p class="message <?php echo $message['type']; ?>"><?php echo $simpleTextile->toHtml($message['text']); ?></p>
		<?php endforeach; ?>

		<?php echo $form->create('Gift', array('url' => $this->here . '/2'))."\n"; ?>
		<?php echo $form->input( 'Gift.id', array('type' => 'hidden'))."\n"; ?>
		<?php echo $form->input( 'Gift.type', array('type' => 'hidden', "value" => "donation"))."\n"; ?>
		<?php echo $form->input( 'Gift.appeal_id', array('type' => 'hidden'))."\n"; ?>

		<?php echo $this->element('../templates/default/contact'); ?>
     	<?php echo $form->submit('Donate', array('class' => 'donate-submit')); ?>
		<?php echo $form->end()?>
	</div>
</div>
	<?php echo $this->element('footer')?>