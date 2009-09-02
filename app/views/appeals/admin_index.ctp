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
		unset($params['sort']);
		unset($params['direction']);
		$th = array(
			$paginator->sort('Starred', 'starred', array('url' => $params)),
			$paginator->sort('Status', 'status', array('url' => $params)),
			$paginator->sort('Campaign Code', 'campaign_code', array('url' => $params)),
			$paginator->sort('Name', 'name', array('url' => $params)),
			$paginator->sort('Default?', 'default', array('url' => $params)),
			$paginator->sort('Reviewed?', 'reviewed', array('url' => $params)),
			$paginator->sort('#Steps', 'steps', array('url' => $params)),
			$paginator->sort('Created By', 'user_id', array('url' => $params)),
			$paginator->sort('Created On', 'created', array('url' => $params)),
			$paginator->sort('Last Update', 'modified', array('url' => $params)),
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