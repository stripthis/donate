<?php
class JsonComponent extends Object {
/**
 * Controller
 *
 * @var object
 * @access public
 */
	var $Controller;
/**
 * Startup Component
 *
 * @param object $Controller
 * @access public
 */
	function startup(&$Controller) {
		$this->Controller =& $Controller;
	}
/**
 * Send out JSON error
 *
 * @param string $message Message to send
 * @param array $parameters Extra parameters, including 'profile' : bool to render a profile message
 * @return mixed What Controller::render() returns
 * @access public
 */
	function error($message, $parameters = array()) {
		return $this->render(false, array_merge(compact('message'), $parameters));
	}
/**
 * Send out JSON success
 *
 * @param string $message Message to send
 * @param array $parameters Extra parameters, including 'profile' : bool to render a profile message
 * @return mixed What Controller::render() returns
 * @access public
 */
	function success($message, $parameters = array()) {
		return $this->render(true, array_merge(compact('message'), $parameters));
	}
/**
 * Send out JSON redirect
 *
 * @param mixed $url URL (gets parsed through Router::url())
 * @param string $message Message to send
 * @param array $parameters Extra parameters, including 'profile' : bool to render a profile message
 * @return mixed What Controller::render() returns
 * @access public
 */
	function redirect($url, $message = '', $parameters = array()) {
		return $this->render(true, array_merge(array(
			'redirect' => Router::url($url)
			, 'message' => $message
		), $parameters));
	}
/**
 * Send out JSON load
 *
 * @param mixed $url URL (gets parsed through Router::url())
 * @param string $message Message to send
 * @param array $parameters Extra parameters, including 'profile' : bool to render a profile message
 * @return mixed What Controller::render() returns
 * @access public
 */
	function load($url, $message = '', $parameters = array()) {
		return $this->render(true, array_merge(array(
			'load_url' => Router::url($url)
			, 'message' => $message
		), $parameters));
	}
/**
 * Render JSON response
 *
 * @param bool $success Success status to send
 * @param unknown_type $parameters Parameters
 * @return mixed What Controller::render() returns
 * @access public
 */
	function render($success, $parameters = array()) {
		$parameters = array_merge(array('exit' => true), $parameters);
		if (!isset($parameters['profile'])) {
			$parameters['profile'] = true;
		}
		if (!empty($parameters['profile']) && isset($parameters['message']) && !empty($parameters['message'])) {
			$parameters['message'] = '<ul class="messages"><li class="' . ($success ?
				'success'
				:
				'error') . '">' . $parameters['message'] . '</li></ul>';
			unset($parameters['profile']);
		}
		if (!$success && isset($parameters['message'])) {
			$parameters['error'] = $parameters['message'];
		}
		if (isset($parameters['message'])) {
			$parameters['responseText'] = $parameters['message'];
		}
		$response = array_merge(compact('success'), array_diff_key($parameters, array('exit' => true)));

		$this->Controller->set(compact('response'));
		$this->Controller->viewPath = 'elements';
		$result = $this->Controller->render('json_response', 'ajax');

		if (!empty($parameters['exit'])) {
			echo $result;
			exit;
		}

		return $result;
	}
}
?>