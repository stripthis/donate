<?php
App::import('Model', array('User', 'AuthKey', 'Page'));
App::import('Core', 'Controller');
/**
 * undocumented class
 *
 * @package default
 * @access public
 */
class AppController extends Controller {
	var $components = array(
		// 'DebugKit.Toolbar',
		'RequestHandler',
		'Message',
		'Cookie',
		'Ssl',
		'AppSession',
		'Json',
		'Email',
		'Silverpop',
		'Pgp'
	);

	// dont change the order unless you really know what you are doing!
	var $plugins = array(
		// 'Bugs',
		'Comments', 'Favorites', 'Tellfriends', 'Logging', 'Chat',
		'Smileys', 'Segments', 'Filters'
	);

	var $helpers = array(
		'Html','Javascript', 'Time', 'Form', 'Common', 'Text', 'Session',
		'Paginator','Plural', 'SimpleTextile', 'Cache', 'MyPaginator',
		'Favorites', 'Chat.AjaxChat', 'Smileys.Smiley'
	);

	var $ignoreUserSession = false;
	var $loginRedirectSesskey = 'login_redirect';
/**
 * App controller
 * Initialize session
 * @return void
 * @access public
 */
	function __construct() {
		if (env('HTTP_X_REQUESTED_WITH') !== "XMLHttpRequest") {
			require_once(COMPONENTS . 'app_session.php');
			$this->Session = new AppSessionComponent();
			$this->Session->__initSession();
		}
		parent::__construct();
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
			Assert::false($this->name == 'App', '404');
			Assert::true(!!$this->action, '404');
		}

		$this->Session = $this->AppSession;
		ClassRegistry::addObject('Component.Session', $this->Session);
		ClassRegistry::addObject('Component.RequestHandler', $this->RequestHandler);
		ClassRegistry::addObject('Component.Cookie', $this->Cookie);
		ClassRegistry::addObject('Component.Email', $this->Email);
		ClassRegistry::addObject('Component.Pgp', $this->Pgp);

		$this->_loadPermissions();
		$this->_setLanguage();
		$this->_loadPluginConfigs();

		if ($this->isAdmin()) {
			$this->layout = 'admin';
		}

		if (defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
			return;
		}

		$this->RequestHandler->setContent('list', 'text/html');
		if (empty($this->ignoreUserSession)) {
			$rules = Configure::read('App.userPermissions.' . User::get('Role.name'));
			Assert::notEmpty($rules, '500');
			$canAccess = Common::requestAllowed($this->name, $this->action, $rules, true);

			if (!$canAccess) {
				Assert::true(User::is('guest'), '403');
				if ($this->isOkForSessionRedirect()) {
					$this->Session->write($this->loginRedirectSesskey, $this->here);
				}
		
				$this->Session->write('cant_access', true);
				return $this->redirect('/admin/auth/login', '403', true);
			}
		
			if (!User::is('guest') && $this->name == 'auth' && $this->action == 'login') {
				$url = '/admin/home';
				if ($this->Session->check($this->loginRedirectSesskey)) {
					$url = $this->Session->read($this->loginRedirectSesskey);
				}
				$this->redirect($url);
			}
		}
		$here = $this->params['url']['url'];
		if (!empty($here) && $here{0} != '/') {
			$here = '/' . $here;
		}
		$this->setJson('here', $here);

		$ajax = $isAjax = false;
		if ($this->isAjax()) {
			$this->layout = 'ajax';
			$ajax = $isAjax = true;
		}

		$this->set(compact('ajax', 'isAjax', 'here'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function isOkForSessionRedirect() {
		if ($this->isAjax()) {
			return false;
		}
	
		$unwantedControllers = array('Auth');
		$unwantedActions = array('login','admin_login');
		
		if (!isset($this->name) || !isset($this->action)) {
			return true;
		}

		$countC = count($unwantedControllers);
		$countA = count($unwantedActions);
		for ($j = 0; $j < $countC; $j++) {
			if ($unwantedControllers[$j] == $this->name) {
				for ($i = 0; $i < $countA; $i++) {
					if ($unwantedActions[$i] == $this->action) {
						return false;
					}
				}
			}
		}
		return true;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _loadPluginConfigs() {
		foreach ($this->plugins as $plugin) {
			include(APP . 'plugins' . DS . low($plugin) . DS . 'config.php');
			Configure::write($config);

			$config = current($config);
			if (isset($config['urls'])) {
				$pass = false;
				foreach ($config['urls'] as $url) {
					if (preg_match($url, $this->here)) {
						$pass = true;
						break;
					}
				}
				if (!$pass) {
					continue;
				}
			}
			$controller = $plugin . 'AppController';
			if (!class_exists($controller)) {
				App::import('Controller', $plugin . '.' . $plugin . 'AppController');
			}

			$Controller = new $controller();
			if (method_exists($Controller, 'init')) {
				$toSet = $Controller->init();
				if (is_array($toSet)) {
					$this->set($toSet);
				}
			}
		}
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _loadPermissions() {
		$Role = ClassRegistry::init('Role');
		$permissions = $Role->find('list', array(
			'fields' => array('name', 'permissions')
		));
		Configure::write('App.userPermissions', $permissions);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function beforeRender() {
		if ($this->isAjax()) {
			return;
		}

		if ($this->Session->check('cant_access') && !$this->Session->check('just_logged_out')) {
			$this->Session->del('cant_access');
			$this->Session->del('just_logged_out');
			$msg = __('You need to login to access this page. If you were logged in previously you might have been logged out because somebody changed your permissions.', true);
			$this->Message->add($msg, 'error');
		}

		if ($this->isAdmin()) {
			$posts = ClassRegistry::init('Post')->find('twitter');

			$widgetState = ClassRegistry::init('WidgetState')->find('first', array(
				'conditions' => array('user_id' => User::get('id'))
			));
			if (!empty($widgetState)) {
				$widgetState = $widgetState['WidgetState'];
			}
			$this->set(compact('posts', 'widgetState'));
		}
	}
/**
 * undocumented function
 *
 * @param string $file 
 * @return void
 * @access public
 */
	function _removeViewCacheFile($file) {
		@unlink(CACHE . 'views' . DS . $file . '.php');
	}
/**
 * undocumented function
 *
 * @param unknown $key
 * @return void
 * @access public
 */
	function _authorizeKey($key) {
		return false;
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function setJson($one, $two = null) {
		$jsonVars = isset($this->viewVars['jsonVars']) ? $this->viewVars['jsonVars'] : array();
		if (is_array($one)) {
			foreach ($one as $key => $val) {
				$jsonVars[$key] = $val;
			}
		} else {
			$jsonVars[$one] = $two;
		}
		$this->set(compact('jsonVars'));
	}
/**
 * undocumented function
 *
 * @param string $url
 * @param string $status
 * @return void
 * @access public
 */
	function redirect($url, $status = null, $exit = true) {
		if (defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
			$this->redirectUrl = Router::url($url);
			return false;
		}
		if ($this->isAjax()) {
			return $this->setJson('redirectUrl', $url);
		}
		parent::redirect($url, $status, $exit);
	}
/**
 * undocumented function
 *
 * @param unknown $return
 * @return void
 * @access public
 */
	function isGet() {
		return $this->RequestHandler->isGet();
	}
/**
 * undocumented function
 *
 * @param unknown $return
 * @return void
 * @access public
 */
	function isPost() {
		return $this->RequestHandler->isPost();
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function isPut() {
		return $this->RequestHandler->isPut();
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function isDelete() {
		return $this->RequestHandler->isDelete();
	}
/**
 * undocumented function
 *
 * @param unknown $return
 * @return void
 * @access public
 */
	function isAjax() {
		if (!isset($this->RequestHandler)) {
			return false;
		}
		return $this->RequestHandler->isAjax();
	}
	
/**
 * Is the controller call in an Admin context?
 * @return bool
 * @access public 
 */	
	function isAdmin(){
		return (isset($this->params['admin']) && $this->params['admin']);
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function _setLanguage($lang = false) {
		$default = 'eng';

		if (!$lang && !User::is('guest')) {
			$lang = User::get('lang');
		}
		if (!$lang && isset($this->params['language'])) {
			$lang = $this->params['language'];
		}
		if (!$lang && $this->Session->check('language')) {
			$lang = $this->Session->read('language');
		}
		if (!$lang && $this->Cookie->read('lang')) {
			$lang = $this->Cookie->read('lang');
		}

		if (!$lang) {
			if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
				$acceptedLanguages = array(
					'en-us' => 'eng',
					'en-gb' => 'eng',
					'fr' => 'fre'
				);

				$settings = explode(';', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
				$settings = $settings[0];
				$settings = explode(',', $settings);
				$settings = $settings[0];

				$lang = $default;
				if (array_key_exists($settings, $acceptedLanguages)) {
					$lang = $acceptedLanguages[$settings];
				}
			}
		}

		$this->Session->write('language', $lang);
		$this->Cookie->write('lang', $lang, true, '20 days');
		Configure::write('Config.language', $lang);
	}
/**
 * Fixing stupid behavior of cake core
 *
 * @param string $a
 * @param string $b
 * @return void
 * @access public
 */
	function set($a, $b = null) {
		if (is_array($a)) {
			foreach ($a as $key => $val) {
				parent::set($key, $val);
			}
		}
		return parent::set($a, $b);
	}
/**
 * undocumented function
 *
 * @param string $model
 * @return void
 * @access public
 */
	function pageForPagination($model) {
		$page = 1;
		$sameModel = isset($this->params['named']['model']) && $this->params['named']['model'] == $model;
		$pageInUrl = isset($this->params['named']['page']);
		if ($sameModel && $pageInUrl) {
			$page = $this->params['named']['page'];
		}

		$this->passedArgs['page'] = $page;
		return $page;
	}
/**
 * undocumented function
 *
 * @param string $data
 * @return void
 * @access public
 */
	function cleanupDate($data) {
		return $data['year'] . '-' . $data['month'] . '-01';
	}
/**
 * undocumented function
 *
 * @param string $msg
 * @return void
 * @access public
 */
	function dispatchFormError($url, $msg = '') {
		$Dispatcher =& new Dispatcher();

		$params = array('formerror' => true);
		if (!empty($msg)) {
			$params['formerror-msg'] = $msg;
		}
		$Dispatcher->dispatch(Router::url($url), $params);
		exit;
	}
}
?>