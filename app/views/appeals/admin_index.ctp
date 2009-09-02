<div class="content" id="appeals_index">
	<h2><?php __('Appeals');?></h2>
	<div class="actions">
		<h3><?php echo __('Actions'); ?></h3>
		<ul>
			<li><?php echo $html->link(__('New Appeal', true), array('action'=>'add'),array('class'=>'add')); ?></li>
		</ul>
	</div>
	<?php if (!empty($appeals)) : ?>
		<table>
		<?php
		$th = array(
			$paginator->sort('starred'),
			$paginator->sort('status'),
			$paginator->sort('campaign_code'),
			$paginator->sort('name'),
			$paginator->sort('default'),
			$paginator->sort('reviewed'),
			$paginator->sort('steps'),
			$paginator->sort('Created By', 'user_id'),
			$paginator->sort('created'),
			$paginator->sort('modified'),
			'Actions'
		);
		echo $html->tableHeaders($th);
		foreach ($appeals as $appeal) {
			$actions = array(
				$html->link(__('View', true), array('action'=>'view', $appeal['Appeal']['id']),array('class'=>'view')),
				$html->link(__('Edit', true), array('action'=>'edit', $appeal['Appeal']['id']),array('class'=>'edit')),
				$html->link(__('Delete', true), array('action'=>'delete', $appeal['Appeal']['id']), array('class'=>'delete'), sprintf(__('Are you sure?', true), $appeal['Appeal']['id']))
			);

			$user = $html->link($appeal['User']['login'], array(
				'controller' => 'users', 'action'=>'view', $appeal['User']['id']
			));
			$tr = array(
				$appeal['Appeal']['starred'],
				$appeal['Appeal']['status'],
				$appeal['Appeal']['campaign_code'],
				$appeal['Appeal']['name'],
				$appeal['Appeal']['default'],
				$appeal['Appeal']['reviewed'],
				$appeal['Appeal']['appeal_step_count'],
				$user,
				$appeal['Appeal']['created'],
				$appeal['Appeal']['modified'],
				implode(' - ', $actions)
			);
			echo $html->tableCells($tr);
		}
		?>
		</table>
		<?php
		$urlParams = $params;
		$urlParams['merge'] = true;
		unset($urlParams['ext']);
		unset($urlParams['page']);
		echo $this->element('paging', array('model' => 'Appeal', 'url' => $urlParams));
		?>
	<?php else : ?>
		<p>Sorry, nothing to show here.</p>
	<?php endif; ?>
	<?php echo $this->element('../appeals/elements/filter', compact('params')); ?>
</div>