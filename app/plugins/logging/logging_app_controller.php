<?php
class LoggingAppController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function init() {
		$config = Configure::read('Logging');

		$RequestHandler = Common::getComponent('RequestHandler');
		$ip = $RequestHandler->getClientIP();
		$userData = User::get();

		foreach ($config['models'] as $model) {
			$Model = ClassRegistry::init($model);

			$attached = $Model->Behaviors->_attached;
			foreach ($attached as $behavior) {
				$Model->Behaviors->detach($behavior);
			}
			$Model->Behaviors->attach('Logging.Logable');
			foreach ($attached as $behavior) {
				$Model->Behaviors->attach($behavior);
			}

			$Model->setUserData($userData);
			$Model->setUserIp($ip);
		}
	}
}
?>