<?php
/**
 * The MessageComponent allows us to easly send little messages to the user directly or after a redirect using
 * the SessionComponent.
 *
 * @package default
 * @access public
 */
class MessageComponent extends Object{
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $Controller;
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $components = array(
		'Session',
		'Json',
		'RequestHandler'
	);
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $sessKey = 'MessageComponent.messages';
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $controllerVar = 'flashMessages';
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $messages = array();
/**
 * undocumented variable
 *
 * @var unknown
 * @access public
 */
	var $sessMessages = array();
/**
 * undocumented function
 *
 * @param unknown $Controller 
 * @return void
 * @access public
 */
	function startup(&$Controller) {
		$this->Controller = &$Controller;

		$this->Json->startup($Controller);
		$this->RequestHandler->startup($Controller);

		$Session = Common::getComponent('Session');
		$sessMessages = $Session->read($this->sessKey);
		if (empty($sessMessages)) {
			return $this->Controller->set($this->controllerVar, array());
		}
		$this->messages = $sessMessages;
		$this->Controller->set($this->controllerVar, $this->messages);
		$Session->delete($this->sessKey);
	}
/**
 * Allows us to add a message with a given $text and $type and to specify whether to show directly
 * or store them into the $session for the next request.
 *
 * @param string $text The text for this message
 * @param string $type The type of this message
 * @param boolean $session If set to true the message will be shown after the next redirect or request
 * @return boolean Returns true on success
 * @access public
*/
	function add($text, $type = 'success', $session = false, $redirect = false, $params = array()) {
		$params['forceNonAjax'] = isset($params['forceNonAjax']) ? $params['forceNonAjax'] : false;
		$params['dontShow'] = isset($params['dontShow']) ? $params['dontShow'] : false;
		if ($this->RequestHandler->isAjax() && !$params['forceNonAjax'] && !$params['dontShow']) {
			if ($redirect) {
				return $this->Json->redirect($redirect, $text);
			}

			if (in_array($type, array('ok', 'success'))) {
				$this->log('success');
				return $this->Json->success($text, $params);
			}
				$this->log('error');
			return $this->Json->error($text, $params);
		}

		$message = array(
			'type' => $type
			, 'text' => $text
		);

		if ($session == true) {
			$this->sessMessages[] = $message;
			$result = $this->writeToSession();
		} else {
			$this->messages[] = $message;
			$this->Controller->set($this->controllerVar, $this->messages);
		}

		if (!empty($redirect)) {
			if ($this->RequestHandler->isAjax()) {
				if ($params['dontShow']) {
					$text = '';
				}
				return $this->Json->redirect($redirect, $text);
			}
			$this->Controller->redirect($redirect);
		}
		return true;
	}
/**
 * Writes all current sess messages to the session.
 *
 * @return void
 * @access public
 */
	function writeToSession() {
		$Session = Common::getComponent('Session');
		$result = $Session->write($this->sessKey, $this->sessMessages);
		return $result;
	}
}
?>