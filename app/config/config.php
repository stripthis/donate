<?php
if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', '');
}
$config = array(
	'App.name' => 'Greenpeace White Rabbit',
	'App.domain' => 'http://donate.greenpeace.org',
	'App.stagingDomain' => 'http://donate.greenpeace.org',
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
	'App.use_email_activation' => false,
	'App.lead_dev_email' => 'rbertot@greenpeace.org',
	'App.recaptcha_key' => '6LfXQgYAAAAAAHH3k76pZcBsbmsI6uustwK4lBF2',
	'App.recaptcha_privkey' => '6LfXQgYAAAAAANChwyDVWumArldovDFn1O8G1TpW',
	'App.avatarSize' => '52', //Avatar stuffs
	'App.avatarDefault' => '/img/layout/defaultAvatar.png',
	'App.newsURL' => 'http://weblog.greenpeace.org/makingwaves/',
	//'App.newsFeed' => 'http://weblog.greenpeace.org/makingwaves/itclimateleaders.xml',
	//'App.twitterURL' => 'http://www.twitter.com/greenpeace',
	//'App.twitterFeed' => 'http://twitter.com/statuses/user_timeline/39753217.rss',
	'App.ipBanTime' => '600',
	'App.maxEmailsSentFromIp' => '50',
	'App.spamEmailTimeLimit' => '600', //Time in seconds in which one email can get referral.
	'App.emailsPerDay' => '5',
	'App.ssl' => array(
		'enabled' => false,
		'actions' => array(
			'/'
		)
	),
	'Stats.startDate' => '-1 year',
	'App.gift_types' => array(
		'donation' => 'Donation'
	),
	'App.gift_mini' => "5",
	'Stats.defaultChartOptions' => array(
		'type' => 'bar_filled',
		'color' => '#006600',
		'outline_col' => '#551285',
		'chart' => array('bg' => '#FFFFFF'),
		'title' => array(
			'style' => 'font-size: 16px; color: gray; padding: 10px;'
		),
		'x_axis' => array(
			'color' => '#BED4F4',
			'grid_colour' => '#BED4F4',
			'tick_height' => 3,
			'stroke' => 2
		),
		'y_axis' => array(
			'colors' => array('#BED4F4', '#BED4F4')
		),
	),
	'App.frequency_options' => array(
		'onetime' => 'One Time',
		'monthly' => 'Monthly',
		//'quarterly' => 'Quarterly',
		//'biannually' => 'Biannually',
		'annualy' => 'Annualy'
	)
);
?>