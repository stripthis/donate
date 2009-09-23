<div class="content" id="transactions_index">
	<h2><?php echo __('Import Transactions', true); ?></h2>
	<?php
	if (isset($result)) {
		if (!$process) {
			$msg = sprintf(
				__('There are %s valid transactions and %s invalid transactions in the file.', true),
				$result['valid'], $result['invalid_missing_parent']
			);
			echo '<p>' . $msg . '</p>';

			echo $html->link('Cancel', array('action' => 'index'));

			if ($result['valid'] > 0) {
				echo $html->link('Process ..', array('action' => 'import', 1));
			}
		} else {
			$msg = sprintf(
				__('%s valid transactions were processed.', true), $result['valid']
			);
			echo '<p>' . $msg . '</p>';

			echo $html->link('Do another import', array('action' => 'import'));
		}

	}

	if (!isset($result)) {
		echo $form->create('Import', array('url' => $this->here, 'type' => 'file'));
		echo $form->input('file', array('label' => 'File', 'type' => 'file'));
		$options = array('friends' => 'Friends Recurring');
		echo $form->input('template', array('label' => 'Template', 'options' => $options));
		echo $form->input('description', array('label' => 'Description', 'type' => 'textbox'));
		echo $form->end('Import');
	}
	?>
</div>