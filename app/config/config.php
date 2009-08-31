<?php
if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', '');
}
$config = array(
	'App.name' => 'Greenpeace White Rabbit',
	'App.domain' => 'http://coolit.greenpeace.org',
	'App.stagingDomain' => 'http://coolit.river01.org',
	'App.mirrorDomain' => 'http://www.greenpeace.org/international/campaigns/climate-change/cool-it-challenge/',
	'App.usingMirror' => true,
	'App.title' => 'Greenpeace White Rabbit',
	'App.browserTitle' => 'Greenpeace White Rabbit | ',
	'App.guestAccount' => 'guest@greenpeace.org',
	'App.supportEmail' => 'general.support@greenpeace.org',
	'App.feedbackEmail' => 'feedback@greenpeace.org',
	'App.bugEmail' => 'general.support@greenpeace.org',
	'App.registrationEmail' => 'Greenpeace White Rabbit <no-reply@greenpeace.org>',
	'App.loginCookieLife' => '+1 year',
	'App.noReplyEmail' => 'Greenpeace White Rabbit <no-reply@greenpeace.org>',
	'App.emailDeliveryMethod' => 'mail',
	'App.smtpOptions' => array(
		'port' => '25',
		'timeout' => '30',
		'host' => 'smtp.river01.org',
		'username' => 'no-reply@river01.org',
		'password' => ''
	),
	'App.use_email_activation' => false,
	'App.easy_voting' => true, // 5-4-3-2-1 betting if false, 1-1 if true
	'App.lead_dev_email' => 'remy@stripthis.com',
	'App.recaptcha_key' => '6LfXQgYAAAAAAHH3k76pZcBsbmsI6uustwK4lBF2',
	'App.recaptcha_privkey' => '6LfXQgYAAAAAANChwyDVWumArldovDFn1O8G1TpW',
	'App.avatarSize' => '52', //Avatar stuffs
	'App.avatarDefault' => '/img/layout/defaultAvatar.png',
	'App.newsURL' => 'http://weblog.greenpeace.org/makingwaves/',
	'App.newsFeed' => 'http://weblog.greenpeace.org/makingwaves/itclimateleaders.xml',
	'App.twitterURL' => 'http://www.twitter.com/coolitchallenge',
	'App.twitterFeed' => 'http://twitter.com/statuses/user_timeline/39753217.rss',
	'App.ipBanTime' => '600',
	'App.maxEmailsSentFromIp' => '50',
	'App.spamEmailTimeLimit' => '600', //Time in seconds in which one email can get referral.
	'App.emailsPerDay' => '5'
	'App.ssl' => array(
		'enabled' => false,
		'actions' => array(
			'/',
		)
	),
	'Stats.startDate' => '-1 year',
	'App.gift_types' => array(
		'donation' => 'Donation'
	),
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
		'quarterly' => 'Quarterly',
		'biannually' => 'Biannually',
		'annualy' => 'Annualy'
	)
);
?>
