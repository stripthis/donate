<?php
class BugsController extends BugsAppController {
	var $components = array('Email');
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_index() {
		$bugs = $this->Bug->find('all', array(
			'contain' => array('User(login)'),
			'order' => array('created' => 'desc')
		));
		$this->set(compact('bugs'));
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_add() {
		if ($this->isGet()) {
			if (isset($this->params['named']['url'])) {
				$this->data['Bug']['url'] = base64_decode($this->params['named']['url']);
			}
			return;
		}
		$this->data['Bug']['user_id'] = User::get('id');

		$this->Bug->id = false;
		$lastBug = $this->Bug->find('first', array(
			'order' => array('increment' => 'desc'),
		));
		$this->data['Bug']['increment'] = !empty($lastBug) 
			? $lastBug['Bug']['increment'] + 1
			: 1;

		$this->Bug->create($this->data);
		if (!$this->Bug->validates()) {
			$msg = __('Please fix the errors below.', true);
			return $this->Message->add($msg, 'error');
		}

		if ($this->Bug->save()) {
			$msg = __('Your bug was successfully reported.', true);
			$this->Message->add($msg, 'ok', true);

			$this->Email->to = Configure::read('App.emails.bug');
			$this->Email->subject = 'Bug report for ' . Configure::read('App.name');
			$this->Email->from = User::get('email');
			$this->Email->charset = 'utf8';
			$this->Email->sendAs = 'text';
			$this->Email->template = 'bugreport';

			$this->data['Bug']['browser'] = !empty($this->data['Bug']['browser']) 
				? $this->data['Bug']['browser'] : 'N/A';

			$content = array(
				'user' => User::get(Configure::read('Bugs.userEmailField'))
				, 'url' => $this->data['Bug']['url']
				, 'last_thing' => $this->data['Bug']['last_thing']
				, 'bug_descr' => $this->data['Bug']['bug_descr']
				, 'browser' => $this->data['Bug']['browser']
				, 'created' => date('Y-m-d')
			);
			$this->set($content);
			$this->Email->send();
		} else {
			$msg = __('There was an error adding your bug.', true);
			$this->Message->add($msg, 'error', true);
		}
		return $this->redirect($this->referer());
	}
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function admin_resent_all($pw = null) {
		Assert::true(User::is('root'), '403');
		$bugs = $this->Bug->find('all');

		foreach ($bugs as $bug) {
			$this->data['Bug'] = $bug['Bug'];

			$this->Email->to = Configure::read('App.emails.bug');
			$this->Email->subject = 'Bug report for ' . Configure::read('App.name');
			$this->Email->from = $bug['User']['email'];
			$this->Email->charset = 'utf8';
			$this->Email->sendAs = 'text';
			$this->Email->template = 'bugreport';

			$content = array(
				'user' => $bug['User']['email']
				, 'url' => $this->data['Bug']['url']
				, 'last_thing' => $this->data['Bug']['last_thing']
				, 'bug_descr' => $this->data['Bug']['bug_descr']
				, 'browser' => $this->data['Bug']['browser']
				, 'created' => $this->data['Bug']['created']
			);
			$this->set($content);
			$this->Email->send();
		}
		$msg = __('Resent all bugs to ' . Configure::read('App.emails.bug') . '.', true);
		die($msg);
	}
/**
 * undocumented function
 *
 * @param string $id 
 * @return void
 * @access public
 */
	function admin_delete($id) {
		Assert::true(User::is('root'), '403');
		$this->Bug->del($id);
		$msg = __('Bug successfully removed!', true);
		$this->Message->add($msg, 'ok', true, array('action' => 'index'));
	}
}

?>