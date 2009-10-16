<?php 
echo $javascript->link('/tellfriends/js/jquery.base64.js');
echo $javascript->link('/tellfriends/js/ajaxRefer.js');

//Check whether tellfriends page is redirected from thanks page.
		if(substr_count(env('HTTP_REFERER'), 'gifts/thanks')){
			$useRecaptcha = 0;
		} else {
			$useRecaptcha = 1; // @todo depend on context; ex: not after donation
		} 
?>
	<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
		<div id="content">
<?php echo $this->element('../templates/default/elements/teasers/title1'); ?>
<?php echo $this->element('../templates/default/elements/teasers/teaser1'); ?>
<?php //echo $this->element('../templates/default/elements/openinviter', array('options' => array('providers'=>$providers)));?>
			<?php echo $form->create('tellafriend', array('url' => array('controller'=>'tellfriends', 'action'=>'refer'))); ?>
<?php echo $this->element('message'); ?>
<?php if($useRecaptcha): ?>
<?php 	echo $this->element('../templates/default/elements/fieldsets/recaptcha'); ?>
<?php endif; ?>
<?php echo $form->input('useRecaptcha', array('type' => 'hidden','value' =>$useRecaptcha ,'div'=>false));?>
			<?php echo $form->end('Send Email'); ?>
		</div>
<?php echo $this->element('../templates/default/elements/footer'); ?>
	</div>
