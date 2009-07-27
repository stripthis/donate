<?php
class CommentsController extends AppController {
/**
 * undocumented function
 *
 * @return void
 * @access public
 */
	function add() {
		$this->edit(null);
	}
/**
 * undocumented function
 *
 * @param string $id
 * @return void
 * @access public
 */
	function edit($id = null) {
		$action = 'add';
		if ($this->action == 'edit') {
			$Comment = $this->Comment->find('first', array(
				'conditions' => array('Comment.id' => $id),
				'contain' => false
			));
			Assert::notEmpty($Comment, '404');
			Assert::true($this->Comment->isOwn($Comment, 'Comment'), '403');
			$action = 'edit';
		} else {
			$Comment = $this->Comment->create();
		}

		$referer = $this->referer();
		$this->set(compact('action', 'referer'));

		$this->action = 'edit';
		if ($this->isGet()) {
			return $this->data = $Comment;
		}

		$this->data['Comment']['user_id'] = User::get('id');
		$this->Comment->set($this->data);

		$result = $this->Comment->save();
		if ($this->Comment->validationErrors) {
			$this->Message->add(DEFAULT_FORM_ERROR, 'error', true, $referer);
		}
		Assert::notEmpty($result);

		$msg = __(DEFAULT_FORM_SUCCESS, true);
		$this->Message->add($msg, 'ok', true, $this->data['Comment']['referer']);
	}
/**
 * undocumented function
 *
 * @param string $id
 * @return void
 * @access public
 */
	 function delete($id = null) {
		$comment = $this->Comment->find('first', array(
			'conditions' => array('Comment.id' => $id),
			'contain' => false
		));

		if (!$this->Comment->isOwn($comment, 'Comment')) {
			$isOwned = false;
			$models = $this->Comment->belongsTo;
			foreach ($models as $model => $data) {
				$row = $this->Comment->{$model}->find('first', array(
					'conditions' => array($model . '.id' => $comment['Comment']['foreign_id'])
				));

				if (!empty($row) && $this->Comment->{$model}->isOwn($row, $model)) {
					$isOwned = true;
					break;
				}
			}
			Assert::true($isOwned, '403');
		}

		if (!$this->Comment->delete($id)) {
			if ($this->isAjax()) {
				return $this->Json->error(DEFAULT_FORM_ERROR, array('profile' => true));
			}
			$dispatcher = new Dispatcher();
			$dispatcher->dispatch($this->referer(), array('formerror' => true, 'formerror-msg' => DEFAULT_FORM_ERROR));
			exit;
		}

		$msg = __(DEFAULT_FORM_DELETE_SUCCESS, true);
		$this->Message->add($msg, 'ok', true, $this->referer());
	}
}
?>