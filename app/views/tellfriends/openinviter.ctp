<?php 
echo $javascript->link('/tellfriends/js/jquery.base64.js');
echo $javascript->link('/tellfriends/js/ajaxRefer.js');

$providers =array(
	'gmail'=>'GMail',
	'hotmail'=>'Live/Hotmail',
	'linkedin'=>'LinkedIn',
	'rediff'=>'Rediff',
	'yahoo'=>'Yahoo!',
	'youtube'=>'YouTube',
	'gmx_net'=>'GMX.net',
	/*
		'abv'=>'Abv',	'aol'=>'AOL',	'apropo'=>'Apropo',	'atlas'=>'Atlas',	'aussiemail'=>'Aussiemail',	'azet'=>'Azet',
		'bigstring'=>'Bigstring',	'bordermail'=>'Bordermail',	'canoe'=>'Canoe',	'care2'=>'Care2',	'clevergo'=>'Clevergo',
		'doramail'=>'Doramail',	'evite'=>'Evite',	'fastmail'=>'FastMail',	'fm5'=>'5Fm',	'freemail'=>'Freemail',
		'gawab'=>'Gawab',	'graffiti'=>'Grafitti',	'hushmail'=>'Hushmail',	'inbox'=>'Inbox.com',	'india'=>'India',	'indiatimes'=>'IndiaTimes',	'inet'=>'Inet',	'interia'=>'Interia',	'katamail'=>'KataMail',
		'kids'=>'Kids',	'libero'=>'Libero',	'lycos'=>'Lycos',	'mail2world'=>'Mail2World',	'mail_com'=>'Mail.com',	'mail_in'=>'Mail.in',	'mail_ru'=>'Mail.ru',	'meta'=>'Meta',	'mynet'=>'Mynet.com',	'netaddress'=>'Netaddress',	'nz11'=>'Nz11',	'o2'=>'O2',	'operamail'=>'OperaMail',	'pochta'=>'Pochta',	'popstarmail'=>'Popstarmail',	'rambler'=>'Rambler',	'sapo'=>'Sapo.pt',	'techemail'=>'Techemail',	'terra'=>'Terra',	'uk2'=>'Uk2',	'virgilio'=>'Virgilio',	'walla'=>'Walla',	'web_de'=>'Web.de',	'wpl'=>'Wp.pt',	'yandex'=>'Yandex',	'zapak'=>'Zapakmail' 
	*/
);
				echo $form->create('openinviter', array(
					'url' =>array('controller'=>'tellfriends', 'action'=>'contactlist') 
				));
			?>
            <div id= "openinviter_login">
			<fieldset id= "openinviter_login1">
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
						<?php echo $form->input('provider_box', array('label' => __('Email provider',true),'options' => $providers)); ?>
					</td>
					<td align='right' id= "errProvider"></td>
				</tr>
				<tr class='thTableImportantRow'>
					<td colspan='2' align='center'><input type='submit' id="import" name='import' value='Import Contacts'></td>
				</tr>
			</table> 
			<?php echo $form->end(); ?>
			</fieldset>
            
            </div>