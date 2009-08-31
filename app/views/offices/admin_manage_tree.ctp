<div class="content" id="offices_index">
	<h2><?php __('Office Tree Management');?></h2>
	<?php echo $this->element('../offices/tree', array('offices' => $treeOffices)); ?>

	<?php
	echo $form->create('Office', array('url' => $this->here));
	foreach ($offices as $office) {
		$office = $office['Office'];
		$options = array();
		foreach ($offices as $oOffice) {
			$oOffice = $oOffice['Office'];
			if ($oOffice['id'] != $office['id']) {
				$options[$oOffice['id']] = $oOffice['name'];
			}
		}
		echo $form->input('options.' . $office['id'], array(
			'options' => $options, 'selected' => $office['parent_id'],
			'label' => $office['name'] . ' -> Select Parent Office:',
			'empty' => '-- None --'
		));
	}
	echo $form->end('Save');
	?>
</div>
