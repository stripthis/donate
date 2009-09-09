<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Appeal');
$favConfig = Configure::read('Favorites');
?>
<div class="content" id="appeals_index">
	<h2><?php __('Appeals');?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'appeal_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
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
		$th = array();
		if ($doFavorites) {
			$th[] = $favorites->favall('Appeal');
		}
		$th = am($th, array(
			$paginator->sort('Status', 'status', array('url' => $params)),
			$paginator->sort('Campaign Code', 'campaign_code', array('url' => $params)),
			$paginator->sort('Name', 'name', array('url' => $params)),
			$paginator->sort('Default?', 'default', array('url' => $params)),
			$paginator->sort('Reviewed?', 'reviewed', array('url' => $params)),
			$paginator->sort('Status', 'status', array('url' => $params)),
			$paginator->sort('#Steps', 'steps', array('url' => $params)),
			$paginator->sort('Created By', 'user_id', array('url' => $params)),
			$paginator->sort('Created On', 'created', array('url' => $params)),
			$paginator->sort('Last Update', 'modified', array('url' => $params)),
			'Actions'
		));
		echo $html->tableHeaders($th);
		foreach ($appeals as $appeal) {
			$actions = array(
				$html->link(__('View', true), array('action'=>'view', $appeal['Appeal']['id']),array('class'=>'view')),
				$html->link(__('Edit', true), array('action'=>'edit', $appeal['Appeal']['id']),array('class'=>'edit')),
				$html->link(__('Delete', true), array('action'=>'delete', $appeal['Appeal']['id']), array('class'=>'delete'), sprintf(__('Are you sure?', true), $appeal['Appeal']['id']))
			);

			if ($appeal['Appeal']['status'] != 'published') {
				$actions[] = $html->link(__('Preview', true), array(
					'controller' => 'gifts', 'action' => 'add',
					'appeal_id' => $appeal['Appeal']['id'], 'admin' => '0'),
					array('class'=>'view'
				));
			}
			$user = $html->link($appeal['User']['login'], array(
				'controller' => 'users', 'action'=>'view', $appeal['User']['id']
			));
			$tr = array();
			if ($doFavorites) {
				$tr[] = $favorites->link("Appeal", $t['Appeal']['id']);
			}
			$tr = am($tr,array(
				$appeal['Appeal']['status'],
				$appeal['Appeal']['campaign_code'],
				$appeal['Appeal']['name'],
				$appeal['Appeal']['default'],
				$appeal['Appeal']['reviewed'],
				ucfirst($appeal['Appeal']['status']),
				$appeal['Appeal']['appeal_step_count'],
				$user,
				$appeal['Appeal']['created'],
				$appeal['Appeal']['modified'],
				implode(' - ', $actions)
			));
			echo $html->tableCells($tr);
		}
		?>
		</table>
		<?php
		$urlParams = $params;
		$urlParams[] = $type;
		$urlParams['merge'] = true;
		unset($urlParams['ext']);
		unset($urlParams['page']);
		echo $this->element('paging', array('model' => 'Appeal', 'url' => $urlParams));
		?>
	<?php else : ?>
		<p>Sorry, nothing to show here.</p>
	<?php endif; ?>
	<?php echo $this->element('../appeals/elements/filter', compact('params', 'type')); ?>
</div>