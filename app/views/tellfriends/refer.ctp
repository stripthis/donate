<?php 
echo $javascript->link('/tellfriends/js/jquery.base64.js');
echo $javascript->link('/tellfriends/js/ajaxRefer.js');

$uses_recaptcha = true; // @todo depend on context; ex: not after donation
?>
	<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
		<div id="content">
<?php //echo $this->element('../templates/default/elements/openinviter', array('options' => array('providers'=>$providers)));?>
			<?php echo $form->create('tellafriend', array('url' => array('controller'=>'tellfriends', 'action'=>'refer'))); ?>
<?php echo $this->element('message'); ?>
<?php if($uses_recaptcha): ?>
<?php 	echo $this->element('../templates/default/elements/fieldsets/recaptcha'); ?>
<?php endif; ?>
			<?php echo $form->end('Send Email'); ?>
		</div>
<?php echo $this->element('../templates/default/elements/footer'); ?>
	</div>
