<?php
if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', '');
}
$config = array(
	'App.environment' => 'production',
	'App.name' => 'Greenpeace White Rabbit',
	'App.domain' => 'https://donate.greenpeace2.org',
	'App.stagingDomain' => 'https://donate.greenpeace.org',
	'App.mirrorDomain' => 'http://www.greenpeace.org/international',
	'App.usingMirror' => true,
	'App.title' => 'Greenpeace (White Rabbit)',
	'App.browserTitle' => '',
	'App.guestAccount' => 'guest@greenpeace.org',
	'App.supportEmail' => 'supporter-services@greenpeace.org',
	'App.feedbackEmail' => 'feedback@greenpeace.org',
	'App.bugEmail' => 'general.support@greenpeace.org',
	'App.registrationEmail' => 'Greenpeace <no-reply@greenpeace.org>',
	'App.loginCookieLife' => '+1 year',
	'App.noReplyEmail' => 'Greenpeace <no-reply@greenpeace.org>',
	'App.emailDeliveryMethod' => 'mail',
	/*'App.smtpOptions' => array(
		'port' => '25',
		'timeout' => '30',
		'host' => 'smtp.greenpeace.org',
		'username' => 'no-reply@greenpeace.org',
		'password' => ''
	),*/
	//'App.newsURL' => 'http://weblog.greenpeace.org/makingwaves/',
	//'App.newsFeed' => 'http://weblog.greenpeace.org/makingwaves/itclimateleaders.xml',
	//'App.twitterURL' => 'http://www.twitter.com/greenpeace',
	//'App.twitterFeed' => 'http://twitter.com/statuses/user_timeline/39753217.rss',
	'App.permission_options' => array(
		'Appeals:admin_add', 'Appeals:admin_edit', 'Appeals:admin_delete', 'Appeals:admin_view',
		'Gifts:admin_add', 'Gifts:admin_edit', 'Gifts:admin_delete', 'Gifts:admin_view',
		'Transactions:admin_add', 'Transactions:admin_edit', 'Transactions:admin_delete',
		'Transactions:admin_view', 'Transactions:admin_export', 'Transactions:admin_import',
		'Users:admin_add', 'Users:admin_edit'
	),
	'App.use_email_activation' => false,
	'App.lead_dev_email' => 'rbertot@greenpeace.org',
	'App.recaptcha_key' => '6LfXQgYAAAAAAHH3k76pZcBsbmsI6uustwK4lBF2',
	'App.recaptcha_privkey' => '6LfXQgYAAAAAANChwyDVWumArldovDFn1O8G1TpW',
	'App.avatarSize' => '52', //Avatar stuffs
	'App.avatarDefault' => '/img/layout/defaultAvatar.png',
	'App.ipBanTime' => '600',
	'App.maxEmailsSentFromIp' => '50',
	'App.spamEmailTimeLimit' => '600', //Time in seconds in which one email can get referral.
	'App.emailsPerDay' => '5',
	'App.ssl' => array(
		'enabled' => true,
		'actions' => array(
			'/'
		)
	),
	'App.lang_options' => array(
		'eng' => 'English',
		'fre' => 'French'
	),
	'Stats.startDate' => '-1 year',
	'App.contact' => array(
		'salutations' => array(
			'ms' => 'Ms.', 
			'mrs' => 'Mrs.', 
			'mr' => 'Mr.'
		),
		'titles' => array(
	    'dr' => 'Dr.',
	    'drdr' => 'Dr. Dr.',
	    'prof' => 'Prof.',
	    'profdr' => 'Prof. Dr.',
	    'profdrdr' => 'Prof. Dr. Dr.',
	    'dipl' => 'Dipl.'
		)
	),
	'App.cards' => array(
		'mastercard' => 'Mastercard',
		'visa' => 'Visa',
		'electron' => 'Visa Electron',
		'diners' => 'Diners Club',
		'amex' => '<small>American Express</small>',
		'jcb' => 'JCB',
		'discover' => 'Discover'
	),
	'Stats.defaultChartOptions' => array(
		'type' => 'bar_filled',
		'color' => '#66CC00',
		'outline_col' => '#006600',
		'chart' => array('bg' => '#FFFFFF'),
		'title' => array(
			'style' => 'font-size: 16px; color: gray; padding: 15px;'
		),
		'x_axis' => array(
			'color' => '#BED4F4',
			'grid_colour' => '#BED4F4',
			'tick_height' => 3,
			'stroke' => 2
		),
		'y_axis' => array(
			'colors' => array('#BED4F4', '#BED4F4')
		)
	)
);
?>
