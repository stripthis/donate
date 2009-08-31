<?php
if (function_exists('ini_set')) {
	ini_set('session.use_trans_sid', 0);
	ini_set('url_rewriter.tags', '');
	ini_set('session.save_handler', 'user');
	ini_set('session.serialize_handler', 'php');
	ini_set('session.use_cookies', 1);
	ini_set('session.name', Configure::read('Session.cookie'));
	ini_set('session.cookie_lifetime', $this->cookieLifeTime);
	ini_set('session.cookie_path', $this->path);
	ini_set('session.auto_start', 0);
}
?>