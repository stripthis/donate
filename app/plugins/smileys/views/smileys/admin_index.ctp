<div class="content" id="smileys_index">
	<h1><?php echo $this->pageTitle = 'Smiley Management'; ?></h1>

	<?php
	echo $html->link(__('Import Smiley File', true), array(
		'controller' => 'smileys', 'action' => 'import', 'admin' => true
	));
	?>
	<?php if (empty($smileys)) : ?>
		<p><?php echo __('Sorry, there aren\'t any smileys yet!', true) ?></p>
	<?php else : ?>
		<table>
		<?php
		$th = array(
			$paginator->sort('code'),
			$paginator->sort('filename'),
			__('Actions', true)
		);
		echo $html->tableHeaders($th);
		foreach ($smileys as $smiley) {
			$actions = array(
				$html->link(__('Delete', true),
					array('action' => 'delete', 'admin' => true, $smiley['Smiley']['id']),
					array('title' => 'Delete'), 'Are you sure?', false
				)
			);

			$tr = array(
				$smiley['Smiley']['code'],
				$html->image('../files/plugins/smileys/' . $smiley['Smiley']['filename']),
				implode(' - ', $actions)
			);
			echo $html->tableCells($tr);
		}
		?>
		</table>
		<?php echo $this->element('paging', array('model' => 'Smiley'))?>
	<?php endif ?>
</div>