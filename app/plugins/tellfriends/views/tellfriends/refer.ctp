<?php
$providers =array(
'abv'=>'Abv','aol'=>'AOL','apropo'=>'Apropo','atlas'=>'Atlas','aussiemail'=>'Aussiemail','azet'=>'Azet','bigstring'=>'Bigstring','bordermail'=>'Bordermail','canoe'=>'Canoe','care2'=>'Care2','clevergo'=>'Clevergo','doramail'=>'Doramail','evite'=>'Evite','fastmail'=>'FastMail','fm5'=>'5Fm','freemail'=>'Freemail','gawab'=>'Gawab','gmail'=>'GMail','gmx_net'=>'GMX.net','graffiti'=>'Grafitti','hotmail'=>'Live/Hotmail','hushmail'=>'Hushmail','inbox'=>'Inbox.com','india'=>'India','indiatimes'=>'IndiaTimes','inet'=>'Inet','interia'=>'Interia','katamail'=>'KataMail','kids'=>'Kids','libero'=>'Libero','linkedin'=>'LinkedIn','lycos'=>'Lycos','mail2world'=>'Mail2World','mail_com'=>'Mail.com','mail_in'=>'Mail.in','mail_ru'=>'Mail.ru','meta'=>'Meta','mynet'=>'Mynet.com','netaddress'=>'Netaddress','nz11'=>'Nz11','o2'=>'O2','operamail'=>'OperaMail','pochta'=>'Pochta','popstarmail'=>'Popstarmail','rambler'=>'Rambler','rediff'=>'Rediff','sapo'=>'Sapo.pt','techemail'=>'Techemail','terra'=>'Terra','uk2'=>'Uk2','virgilio'=>'Virgilio','walla'=>'Walla','web_de'=>'Web.de','wpl'=>'Wp.pt','yahoo'=>'Yahoo!','yandex'=>'Yandex','youtube'=>'YouTube','zapak'=>'Zapakmail' 
 );
?>
<?php echo $javascript->link('/tellfriends/js/ajaxRefer.js'); ?>
<div id="referDiv">
	<?php 
		echo $form->create('openinviter', array(
			'url' =>array('controller'=>'tellfriends', 'action'=>'contactList') 
		)); 
	?>
	<table align='center' class='thTable' cellspacing='6' cellpadding='3' style='border:none;' border="0">
		<tr>
			<td colspan='2' align='center'>OpenInviter</td>
		</tr>
		<tr class='thTableRow'>
		
			<td>
				<?php  echo $form->input('email_box', array('type' => 'text','label' => __('Email',true),'error' => 'Please specify a valid Email')); ?>
				<?php // echo $form->input('password');?>
			</td>
            	<td id= "errEmail"></td>
		</tr>
		<tr class='thTableRow'>
		
			<td><?php  echo $form->input('password_box', array('type' => 'password','label' => __('Password',true),'class'=>'Please specify a valid Password')); ?></td>
            	<td id= "errPass"></td>
		</tr>
		<tr class='thTableRow'>
			
			<td>
				<?php echo $form->input('provider_box', array('label' => __('Email provider',true),'options' => $providers)); ?>
			</td>
            <td align='right' id= "errProvider"></td>
		</tr>
		<tr class='thTableImportantRow'>
			<td colspan='2' align='center'><input type='button' id="import" name='import' value='Import Contacts'></td>
		</tr>
	</table> 
	<?php echo $form->end(); ?>
	<?php echo $form->create('tellafriend', array('url' =>array('controller'=>'tellfriends', 'action'=>'refer')   )); ?>
	<fieldset>
	  <legend><?php echo __('Tell A Friend', true); ?></legend>
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
