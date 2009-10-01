<?php
$providers =array(
  'aol'=>'AOL',
  'gmail'=>'Gmail',
   'yahoo'=>'Yahoo',
   'hotmail'=>'Hotmail'
 );
?>
<?php echo $javascript->link('/tellfriends/js/ajaxRefer.js'); ?>
<div id="referDiv">
	<?php 
		echo $form->create('openinviter', array(
			'url' =>array('controller'=>'tellfriends', 'action'=>'contactList') 
		)); 
	?>
	<table align='center' class='thTable' cellspacing='0' cellpadding='0' style='border:none;'>
		<tr>
			<td colspan='2' align='center'>OpenInviter</td>
		</tr>
		<tr class='thTableRow'>
			<td align='right'></td>
			<td>
				<?php  echo $form->input('email_box', array('type' => 'text','label' => __('Email',true),'class'=>'input text required')); ?>
				<?php // echo $form->input('password');?>
			</td>
		</tr>
		<tr class='thTableRow'>
			<td align='right'></td>
			<td><?php  echo $form->input('password_box', array('type' => 'password','label' => __('Password',true),'class'=>'input text required')); ?></td>
		</tr>
		<tr class='thTableRow'>
			<td align='right'></td>
			<td>
				<?php echo $form->input('provider_box', array('label' => __('Email provider',true),'options' => $providers)); ?>
			</td>
		</tr>
		<tr class='thTableImportantRow'>
			<td colspan='2' align='center'><input type='button' id="import" name='import' value='Import Contacts'></td>
		</tr>
	</table> 
	<?php echo $form->end(); ?>
	<?php echo $form->create('tellafriend', array('url' =>array('controller'=>'tellfriends', 'action'=>'refer')   )); ?>
	<fieldset>
	  <legend><?php sprintf(__('Tell A Friend', true)); ?></legend>
	  <div id = "contactList">
	 </div>
	  <ul>
	    <li>
	      <?php echo $form->input('Tellfriend.receiver', array('type' => 'text','label' => __('Friends\' Email (comma separated emails)',true).' *','class'=>'input text required','div'=>false))?>
	    </li>
			<li>
				<?php echo $form->input('Tellfriend.sender', array('type' => 'text','label' => __('Your Email',true).' (Optional)','class'=>'input text required','div'=>false))?>
			</li>
			<li>
	      <?php echo $form->input('Tellfriend.content', array('type' => 'textarea','label' => __('Your Message',true),'class'=>'input text required','div'=>false, 'value' => __('Hi, Your friend wants you to check out this website: www.greenpeace.org ', true)))?>
	    </li>
	     <li>
	      <?php $recaptcha->display_form('echo'); ?>
	    </li>
	    
	    <li>
		 <?php echo $form->end('Send Email'); ?>
	    </li>
	  </ul>
	</fieldset>
</div>
