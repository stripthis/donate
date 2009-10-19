<?php
class CommentsController extends CommentsAppController {
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
	function edit($id = null, $parentId = null) {
		$action = 'add';
		if ($this->action == 'edit') {
			$Comment = $this->Comment->find('first', array(
				'conditions' => array('Comment.id' => $id)
			));
			Assert::notEmpty($Comment, '404');
			Assert::true($this->Comment->isOwn($Comment, 'Comment'), '403');
			$action = 'edit';
		} else {
			$Comment = $this->Comment->create();
		}

		$referer = $this->referer();
		$parentId = isset($this->params['named']['parent_id'])
						? $this->params['named']['parent_id']
						: false;
		$foreignId = isset($this->params['named']['foreign_id'])
						? $this->params['named']['foreign_id']
						: false;
		$this->set(compact('action', 'referer', 'parentId', 'foreignId'));

		$this->action = 'edit';
		if ($this->isGet()) {
			return $this->data = $Comment;
		}

		$this->data['Comment']['user_id'] = User::get('id');
		$this->Comment->set($this->data);

		$result = $this->Comment->save();
		if ($this->Comment->validationErrors) {
			$msg = __('There are problems with the form.', true);
			$this->Message->add($msg, 'error', true, $referer);
		}
		Assert::notEmpty($result);

		$msg = __('Successfully saved!', true);
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
			'conditions' => array('Comment.id' => $id)
		));
		Assert::true(Comment::isOwn($comment));

		if (!$this->Comment->delete($id)) {
			if ($this->isAjax()) {
				$msg = __('There are problems with the form.', true);
				return $this->Json->error($msg, array('profile' => true));
			}
			$dispatcher = new Dispatcher();
			$dispatcher->dispatch($this->referer(), array(
				'formerror' => true,
				'formerror-msg' => __('There are problems with the form.', true)
			));
			exit;
		}

		$msg = __('Successfully deleted!', true);
		$this->Message->add($msg, 'ok', true, $this->referer());
	}
}
?>