<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Appeal');
$favConfig = Configure::read('Favorites');
?>
<div class="content" id="appeals_index">
	<h2><?php echo __('Appeals', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'appeal_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<div class="actions">
		<h3><?php echo __('Actions', true); ?></h3>
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
			$paginator->sort('Name', 'name', array('url' => $params)),
			$paginator->sort('Campaign Code', 'campaign_code', array('url' => $params)),
			'Income',
			'Signups',
			$paginator->sort('Last Update', 'modified', array('url' => $params)),
			'Actions'
		));
		echo $html->tableHeaders($th);
		foreach ($appeals as $appeal) {
			$actions = array(
				$html->link(__('Config', true), array('action'=>'view', $appeal['Appeal']['id']),array('class'=>'view')),
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
				$appeal['Appeal']['name'],
				$appeal['Appeal']['campaign_code'],
				'',
				'',
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
		<p><?php echo __('Sorry, nothing to show here.', true); ?></p>
	<?php endif; ?>
	<?php echo $this->element('../appeals/elements/filter', compact('params', 'type')); ?>
</div>