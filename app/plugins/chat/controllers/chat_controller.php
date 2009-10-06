<?php
class ChatController extends ChatAppController {
/**
 * undocumented function
 *
 * @param string $key 
 * @return void
 * @access public
 */ 
	function update($key) {
		$messages = $this->Chat->find('latest', compact('key'));
		$this->set(compact('messages'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_post() {
		App::import('Sanitize');
		$this->data['Chat']['ip_address'] = $this->RequestHandler->getClientIP();
		$this->data['Chat']['user_id'] = User::get('id');
		$this->Chat->create($this->data);
		$this->Chat->save(null, false);
		die;
	}
}
?>