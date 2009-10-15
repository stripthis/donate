<?php
if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', '');
}
$config = array(
	'App.environment' => 'production',
	'App.name' => 'Greenpeace White Rabbit',
	'App.domain' => 'https://donate.greenpeace.org',
	'App.stagingDomain' => 'https://donate.greenpeace.org',
	'App.mirrorDomain' => 'http://www.greenpeace.org/international',
	'App.usingMirror' => true,
	'App.title' => 'Donate | Greenpeace',
	'App.browserTitle' => '',
	'App.loginCookieLife' => '+1 month',
	'App.emailDeliveryMethod' => 'mail',
	'App.use_email_activation' => false,
	'App.emails' => array(
		'guestAccount' => 'guest@greenpeace.org',
		'support' => 'supporter-services@greenpeace.org',
		'feedback' => 'feedback@greenpeace.org',
		'bug' => 'general.support@greenpeace.org',
		'registration' => 'Greenpeace <no-reply@greenpeace.org>',
		'noReply' => 'Greenpeace <no-reply@greenpeace.org>',
		'lead_dev' => 'rbertot@greenpeace.org',
	),
	'App.legal' => array(
		'ageMini' => 16
	),
	/*'App.smtpOptions' => array(
		'port' => '25',
		'timeout' => '30',
		'host' => 'smtp.greenpeace.org',
		'username' => 'no-reply@greenpeace.org',
		'password' => ''
	),*/
	'App.permissions' => array(
		'options' => array(
			'Appeals:admin_add', 'Appeals:admin_edit', 'Appeals:admin_delete', 'Appeals:admin_view', 'Appeals:publish',
			'Gifts:admin_add', 'Gifts:admin_edit', 'Gifts:admin_delete', 'Gifts:admin_view',
			'Transactions:admin_add', 'Transactions:admin_edit', 'Transactions:admin_delete',
			'Transactions:admin_view', 'Transactions:admin_export', 'Transactions:admin_import',
			'Users:admin_add', 'Users:admin_edit', 'Users:admin_view', 'Users:admin_delete', 
			'Users:admin_email_reports', 'Roles:admin_view', 'Roles:admin_add', 'Roles:admin_edit', 'Roles:admin_delete',
			'Exports:admin_gifts', 'Logs:admin_index',
			'Offices:admin_view', 'Offices:admin_add', 
			//'Bugs:admin_view', 'Bugs:admin_add'
		)
	),
	'App.recaptcha' => array(
		'publicKey' => '6LfXQgYAAAAAAHH3k76pZcBsbmsI6uustwK4lBF2',
		'privateKey' => '6LfXQgYAAAAAANChwyDVWumArldovDFn1O8G1TpW',
		'apiServer' => 'http://api.recaptcha.net',
		'apiSecureServer' => 'https://api-secure.recaptcha.net',
		'verifyServer' => 'api-verify.recaptcha.net'
	),
	'App.avatar' => array(
		'size' => '52',
		'default' => '/img/layout/defaultAvatar.png',
	),
	'App.tellafriend' => array(
		'ipBanTime' => '600',
		'maxEmailsSentFromEmail' => '50',
		'maxEmailsSentFromIp' => '50',
		'spamEmailTimeLimit' => '600', //Time in seconds in which one email can get referral.
		'emailsPerDay' => '5'
	),
	'App.ssl' => array(
		'enabled' => false,
		'actions' => array(
			'/'
		)
	),
	'App.languages' => array(
		'eng' => 'English',
		'fre' => 'French'
	),
	'App.gift' => array(
		'types' => array(
			'donation' => 'Donation',
			'inkind' => 'In-kind gift',
			'legacy' => 'Legacy'
		),
		'currencies' => array(
			'USD', 'EUR','GBP'
		),
		'cards' => array(
			'mastercard' => 'Mastercard',
			'visa' => 'Visa',
			'electron' => 'Visa Electron',
			'diners' => 'Diners Club',
			'amex' => '<small>American Express</small>',
			'jcb' => 'JCB',
			'discover' => 'Discover'
		)
	),
	'App.tax_receipts' => array(
		'enabled' => false
	),
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
	// Statistics module (flash)
	'Stats.startDate' => '-1 year',
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
	),
	// News & Feeds
	'App.rss' => array(
		'news' => array(
			'title' => 'making waves',
			'link' => 'http://weblog.greenpeace.org/makingwaves/',
			'url' => 'http://feeds.feedburner.com/MakingWaves'
		)
		//'App.twitterURL' => 'http://www.twitter.com/greenpeace',
		//'App.twitterFeed' => 'http://twitter.com/statuses/user_timeline/39753217.rss',
	)
);
?>
