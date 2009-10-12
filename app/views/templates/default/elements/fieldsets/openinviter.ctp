<?php 
	echo $form->create('openinviter', array(
		'url' =>array('controller'=>'tellfriends', 'action'=>'contactList') 
	));
?>
<fieldset>
	<legend><?php __('Open Inviter'); ?></legend>
	<table align='center' class='thTable' cellspacing='6' cellpadding='3' style='border:none;' border="0">
		<tr class='thTableRow'>
			<td>
				<?php	echo $form->input('email_box', array('type' => 'text','label' => __('Email',true),'error' => 'Please specify a valid Email')); ?>
				<?php // echo $form->input('password');?>
			</td>
			<td id= "errEmail"></td>
		</tr>
		<tr class='thTableRow'>
			<td><?php	echo $form->input('password_box', array('type' => 'password','label' => __('Password',true),'class'=>'Please specify a valid Password')); ?></td>
			<td id= "errPass"></td>
		</tr>
		<tr class='thTableRow'>
			<td>
				<?php echo $form->input('provider_box', array('label' => __('Email provider',true),'options' => $options['providers'])); ?>
			</td>
			<td align='right' id= "errProvider"></td>
		</tr>
		<tr class='thTableImportantRow'>
			<td colspan='2' align='center'><input type='button' id="import" name='import' value='Import Contacts'></td>
		</tr>
	</table> 
	<?php echo $form->end(); ?>
</fieldset>