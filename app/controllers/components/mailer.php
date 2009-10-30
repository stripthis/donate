<?php

class Mailer{
	static function deliver($template, $options = array()) {
		$options = Set::merge(array(
			'vars' => array(),
			'mail' => array(
				'to' => array(),
				'from' => Configure::read('App.emails.noReply'),
				'charset' => 'utf8',
				'sendAs' => 'text',
				'subject' => '',
				'template' => $template,
				'layout' => 'email',
				'attachments' => array()
			),
			'store' => false
		), $options);

		if (!empty($options['mail']['subject'])) {
			$options['mail']['subject'] = strip_tags($options['mail']['subject']);
		}

		$delivery = Configure::read('App.emailDeliveryMethod');
		if (!empty($delivery) && !isset($options['mail']['delivery'])) {
			$options['mail']['delivery'] = $delivery;
		}

		
		if (isset($options['mail']['delivery']) && $options['mail']['delivery'] == 'smtp') {
			$options['mail']['smtpOptions'] = Configure::read('App.smtpOptions');
		}

		if (Common::isDevelopment()) {
			$options['mail']['delivery'] = 'debug';
		}

		App::import('Core', 'Controller');
		$Email = Common::getComponent('Email');
		Common::setProperties($Email, $options['mail']);

		if (!isset($Email->Controller)) {
			App::import('Core', 'Router');
			$Email->Controller = new AppController();
		}

		$Email->Controller->set($options['vars']);

		if ($options['store']) {
			$hash = sha1(json_encode($options));
			$folder = substr($hash, 0, 2);
			$file = substr($hash, 2).'.html';
			$url = '/emails/'.$folder.'/'.$file;
			$path = APP.'webroot'.$url;
			if (!is_dir(dirname($path))) {
				@mkdir(dirname($path));
			}
			$url = Router::url($url, true);
			$Email->Controller->set('emailUrl', $url);

			$View = new View($Email->Controller, false);
			$View->layout = $Email->layout;
			$View->layoutPath = 'email' . DS . 'html';
			$html = $View->element('email' . DS . 'html' . DS . $options['mail']['template'], array('content' => null), true);
			$html = $View->renderLayout($html);
			file_put_contents($path, $html);
		}

		if (!isset($Email->Controller->Session)) {
			$Email->Controller->Session = Common::getComponent('Session');
		}
		$result = $Email->send();
		if (Common::isDevelopment() && Configure::read('App.email_debug')) {
			Common::debugEmail();
		}
		return $result;
	}
}
?>