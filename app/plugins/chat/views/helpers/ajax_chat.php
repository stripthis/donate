<?php
class AjaxChatHelper extends Helper {
	var $helpers = array('Html', 'Javascript', 'Form');
/**
 * undocumented function
 *
 * @param string $key 
 * @return void
 * @access public
 */
	function generate($key) {
		$id = sprintf('chat_%s', $key);
		echo $this->Javascript->codeBlock('
			$(document).ready(function(){
				$("#' . $id . '").chat();
			});
		');

		echo '<div id="' . $id. '" class="chat" name="' . $key . '">';
		echo '<div class="chat_window"><p>Loading...</p></div>';
		echo $this->Form->create('Chat', array(
			'id' => $key . 'ChatForm', 'url' => array('controller' => 'chat', 'action' => 'post')
		));
		echo $this->Form->input('key', array('type' => 'hidden', 'value' => $key));
 		echo $this->Form->input('message', array('id' => $key . 'ChatMessage', 'type' => 'textarea'));
		echo $this->Form->end(__('Send', true));
 		echo '</form></div>';
	}
}
?>