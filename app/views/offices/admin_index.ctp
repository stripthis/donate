<div class="content" id="offices_index">
	<h2><?php echo __('Offices', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_root_admin_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<div class="actions">
		<h3><?php echo __('Actions', true); ?></h3>
		<ul>
			<li>
				<?php echo $html->link(__('New Office', true), array('action' => 'add'), array('class' => 'add')); ?>
			</li>
			<li>
				<?php
				echo $html->link(__('Manage Tree', true),
					array('action' => 'manage_tree'),
					array('class' => 'tree')
				);
				?>
			</li>
		</ul>
	</div>
	<table>
	<?php
	$th = array(
		$myPaginator->sort(__('Name', true), 'name'),
		$myPaginator->sort(__('Parent', true), 'parent_id'),
		$myPaginator->sort(__('Created', true), 'created'),
		$myPaginator->sort(__('Modified', true), 'modified'),
		'Actions'
	);
	echo $html->tableHeaders($th);
	foreach ($offices as $office) {
		$actions = array(
			$html->link(__('Edit', true), array('action' => 'edit', $office['Office']['id']), array('class'=>'edit')),
			$html->link(__('Delete', true), array('action' => 'delete', $office['Office']['id']),
				array('class' => 'delete'), __('Are you sure?', true))
		);

		$tr = array(
			$office['Office']['name'],
			$office['ParentOffice']['name'],
			date('F d Y', strtotime($office['Office']['created'])),
			$time->timeAgoInWords($office['Office']['modified']),
			implode(' - ', $actions)
		);
		echo $html->tableCells($tr);
	}
	?>
	</table>
	<?php echo $this->element('paging', array('model' => 'Office'))?>
</div>