<?php
App::import('Vendor', 'CakeSsl');
/**
 * Wrapper to offer SSL support to CakePHP urls.
 *
 * @package default
 * @access public
 */
class SslComponent extends Object {
	public $enabled;
	public $actions;
	public $ssl;
	public $base;
/**
 * Startup Component
 *
 * @param object $Controller
 * @access public
 */
	public function startup($Controller) {
		$CakeSsl = new CakeSsl($Controller->base);
		if ($CakeSsl->applies($Controller->here)) {
			$params = isset($Controller->params['url']) ? $Controller->params['url'] : array();
			$params = array_diff_key($params, array('url' => true, 'ext' => true));
			if (!empty($params)) {
			pr($params);
				$params = http_build_query($params);
			}

			$Controller->redirect($CakeSsl->url($Controller->here) . (!empty($params) ? '?' . $params : ''));
			exit;
		}
	}
}

?>