<?php
/**
 * Wrapper to offer SSL support to CakePHP urls.
 *
 * @author Mariano Iglesias
 */
class CakeSsl extends Object {
	public $enabled;
	public $actions;
	public $ssl;
	public $base;
/**
 * Constructor
 *
 * @param string $base Base URL
 * @access public
 */
	public function __construct($base = null) {
		$this->enabled = true;
		$this->actions = array();
		$this->ssl = env('HTTPS');
		$this->base = $base;

		if (Configure::read('App.ssl.enabled') !== null) {
			$this->enabled = Configure::read('App.ssl.enabled');
		}

		if (Configure::read('App.ssl.actions') !== null) {
			$this->actions = Configure::read('App.ssl.actions');
		}
	}
/**
 * Sets or gets the enabled status.
 *
 * @param bool $enabled Set to true to enable, false to disable, or empty to get value
 * @return bool Status of enabled
 * @access public
 */
	public function enabled($enabled = null) {
		if ($enabled !== null) {
			$this->enabled = $enabled;
		}

		return $this->enabled;
	}
/**
 * Tells if being accessed through SSL.
 *
 * @return bool true if on SSL, false otherwise
 * @access public
 */
	function onSsl() {
		return $this->ssl;
	}

/**
 * Tells if the specified path is a SSL protected action.
 *
 * @param string $path Path to check (e.g: /orders/checkout)
 * @return bool true if should be accessed via SSL, false otherwise
 * @access public
 */
	public function isSsl($path) {
		$isSsl = false;
		$path = '/' . $this->__cakeAction($path);

		if ($this->enabled && !empty($path) && !empty($this->actions)) {
			foreach ($this->actions as $sslAction) {
				if (strpos($sslAction, '$') === false) {
					$sslAction .= '(.*)$';
				}
				$isSsl = preg_match('|^' . $sslAction . '|i', $path);
				if ($isSsl) {
					break;
				}
			}
		}

		return $isSsl;
	}
/**
 * Returns fully qualified URL to specified path.
 *
 * @param mixed $url Cake URL (array / string)
 * @param bool $check If true, only alter (and return) $url when applicable
 * @return string URL
 * @access public
 */
	public function url($url, $check = false) {
		if (!$this->enabled) {
			return $url;
		}

		if ($check && $this->applies($url)) {
			$url =  $this->url($url);
		} else {
			$url = $this->__cakeAction($url);

			if ($this->isSsl($url)) {
				$url = 'https://' . $_SERVER['SERVER_NAME'] . (!empty($this->base) ? $this->base : '') . '/' . $url;
			} else {
				$url = 'http://' . $_SERVER['SERVER_NAME'] . (!empty($this->base) ? $this->base : '') . '/' . $url;
			}
		}

		return $url;
	}
/**
 * Tells if a protocol change applies to $url
 *
 * @param mixed $url Cake URL (array / string)
 * @return bool true if change applies, false otherwise
 * @access public
 */
	public function applies($url) {
		$isSsl = $this->isSsl($url);
		$onSsl = $this->onSsl();

		return ($this->enabled && (($isSsl && !$onSsl) || (!$isSsl && $onSsl)));
	}
/**
 * Remove base path from specified path and starting slash.
 *
 * @param mixed $url Cake URL (array / string)
 * @return string Normalized path
 * @access private
 */
	private function __cakeAction($url) {
		if (is_array($url)) {
			$url = Router::url($url);
		}

		if (!empty($url)) {
			if (!empty($this->base) && strpos($url, $this->base) === 0) {
				$url = substr($url, strlen($this->base));
			}

			$url = ($url[0] == '/' ? substr($url, 1) : $url);
		}

		return $url;
	}
}
?>