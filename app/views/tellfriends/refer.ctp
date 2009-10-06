<?php 
echo $javascript->link('/tellfriends/js/jquery.base64.js');
echo $javascript->link('/tellfriends/js/ajaxRefer.js');
?>
<style type="text/css">
@import "js/datepicker/jquery.datepick.css";
</style>
<?php
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
$use_recaptcha = true; // @todo depend on context; ex: not after donation
?>
	<div id="content_wrapper">
<?php echo $this->element('../templates/default/elements/banner'); ?>
		<div id="content">
<?php echo $this->element('../templates/default/elements/openinviter', array('options' => array('providers'=>$providers)));?>
			<?php echo $form->create('tellafriend', array('url' => array('controller'=>'tellfriends', 'action'=>'refer'))); ?>
<?php echo $this->element('message'); ?>
<?php if($use_recaptcha): ?>
<?php 	echo $this->element('../templates/default/elements/recaptcha'); ?>
<?php endif; ?>
			<?php echo $form->end('Send Email'); ?>
		</div>
<?php echo $this->element('../templates/default/elements/footer'); ?>
	</div>
