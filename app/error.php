<?php

uses('error');
/**
 * undocumented class
 *
 * @package default
 * @access public
 */
class AppError extends ErrorHandler{
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function __construct($what) {
		$args = func_get_args();
		if (!defined('INTERNAL_CAKE_ERROR') && !in_array($what, array('error404', 'missingController'))) {
			define('INTERNAL_CAKE_ERROR', true);
		}
		return call_user_func_array(array($this, 'parent::__construct'), $args);
	}
/**
 * New Exception handler, renders an error view, then quits the application.
 *
 * @param object $Exception AppException object to handle
 * @return void
 * @access public
 */
	static function handleException($Exception) {
		$Exception->render();
		exit;
	}
/**
 * Throws an AppExcpetion if there is no db connection present
 *
 * @return void
 * @access public
 */
	function missingConnection() {
		throw new AppException('db_connect');
	}
	
	function error404($params) {
		$Dispatcher = new Dispatcher();
		$Dispatcher->dispatch('/legacy_urls/map', array('broken-url' => '/'.$params['url']));
		exit;
	}
	
	function missingController($params) {
		$Dispatcher = new Dispatcher();
		$Dispatcher->dispatch('/legacy_urls/map', array('broken-url' => '/'.$params['url']));
		exit;
	}

}
set_exception_handler(array('AppError', 'handleException'));

/**
 * Cool class doing exceptional work : )
 *
 * @package default
 * @access public
 */
class AppException extends Exception {
/**
 * Details about what caused this Exception
 *
 * @var array
 * @access public
 */
	var $info = null;
/**
 * undocumented function
 *
 * @param mixed $info A string desribing the type of this exception, or an array with information
 * @return void
 * @access public
 */
	function __construct($info = 'unknown') {
		if (!is_array($info)) {
			$info = array('type' => $info);
		}

		if(!isset($info['type'])) {
			$info['type'] = 'fatal';
		}

		$this->info = $info;
	}
/**
 * Renders a view with information about what caused this Exception. $info['type'] is used to determine what
 * view inside of views/exceptions/ is used. The default is 'unknown.ctp'.
 *
 * @return void
 * @access public
 */
	function render() {
		$info = am($this->where(), $this->info);

		$Controller = new AppController();
		$Controller->viewPath = 'exceptions';
		$Controller->layout = 'exception';

		$Dispatcher = new Dispatcher();
		$Controller->base = $Dispatcher->baseUrl();
		$Controller->webroot = $Dispatcher->webroot;

		$isException = true;
		$Controller->set(compact('info', 'isException'));
		$Controller->beforeRender();

		$View = new View($Controller);

		$view = @$info['type'];
		if (!file_exists(VIEWS.'exceptions'.DS.$view.'.ctp')) {
			$view = 'unknown';
		}

		header("HTTP/1.0 500 Internal Server Error");
		echo $View->render($view);
		return;
	}
/**
 * Returns an array describing where this Exception occured
 *
 * @return array
 * @access public
 */
	function where() {
		return array(
			'function' => $this->getClass().'::'.$this->getFunction()
			, 'file' => $this->getFile()
			, 'line' => $this->getLine()
			, 'url' => $this->getUrl()
		);
	}
/**
 * Returns the url where this Exception occured
 *
 * @return string
 * @access public
 */
	function getUrl($full = true) {
		return Router::url(array('full_base' => $full));
	}
/**
 * Returns the class where this Exception occured
 *
 * @return void
 * @access public
 */
	function getClass() {
		$trace = $this->getTrace();
		return $trace[0]['class'];
	}
/**
 * Returns the function where this Exception occured
 *
 * @return void
 * @access public
 */
	function getFunction() {
		$trace = $this->getTrace();
		return $trace[0]['function'];
	}
}

?>