<div class="content" id="segments_index">
	<h1><?php echo $this->pageTitle = 'Adding a Segment'; ?></h1>

	<p><?php echo __('Segments will show up in the sidebar as a widget.', true) ?></p>
	<?php
	echo $form->create('Segment', array('action' => 'add/1'));
	echo $form->input('referer', array('type' => 'hidden', 'value' => $referer));
	echo $form->input('model', array('type' => 'hidden'));
	echo $form->input('items', array('type' => 'hidden'));

	$hasSome = false;
	if (!empty($form->data['Segment']['segments'])) {
		$hasSome = true;
		echo $form->input('id', array(
			'label' => __('Choose An Existing Segment:', true),
			'options' => $form->data['Segment']['segments']
		));
	}

	$label = !$hasSome
				? __('Label your segment:', true)
				: __('Or add a new one:', true);
	echo $form->input('name', compact('label'));
	echo $form->end('Save');
	?>
</div>