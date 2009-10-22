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
	echo $this->element('../appeals/elements/actions');
	?>
	<?php if (!empty($appeals)) : ?>
		<table>
		<?php
		unset($params['sort']);
		unset($params['direction']);
		$th = array();
		if ($doFavorites) {
			$th[] = $favorites->favall('Appeal');
		}

		$options = array('url' => $params);
		$th = am($th, array(
			$paginator->sort(__('Status', true), 'status', $options),
			$paginator->sort(__('Is Default?', true), 'default', $options),
			$paginator->sort(__('Name', true), 'name', $options),
			$paginator->sort(__('Campaign Code', true), 'campaign_code', $options),
			$paginator->sort(__('Targeted Income', true), 'targeted_income', $options),
			$paginator->sort(__('Targeted Signups', true), 'targeted_signups', $options),
			$paginator->sort(__('Current Template', true), 'Template.name', $options),
			$paginator->sort(__('Created', true), 'created', $options),
			$paginator->sort(__('Last Update', true), 'modified', $options),
			'Actions'
		));
		echo $html->tableHeaders($th);
		foreach ($appeals as $appeal) {
			$actions = array(
				$html->link(__('Config', true),
					array('action' => 'view', $appeal['Appeal']['id']),
					array('class' => 'view')
				),
				$html->link(__('Clone', true),
					array('action' => 'add', 'clone_id' => $appeal['Appeal']['id']),
					array('class' => 'view')
				),
			);

			$actions[] = $html->link(
				($appeal['Appeal']['status'] != 'published') ? __('Preview', true) : __('View', true),
				array(
					'controller' => 'gifts', 'action' => 'add',
					'appeal_id' => $appeal['Appeal']['id'], 'admin' => '0'
				),
				array('class' => 'view')
			);
			$user = $html->link($appeal['User']['login'], array(
				'controller' => 'users', 'action'=>'view', $appeal['User']['id']
			));
			$tr = array();
			if ($doFavorites) {
				$tr[] = $favorites->link("Appeal", $t['Appeal']['id']);
			}
			$tr = am($tr,array(
				ucfirst($appeal['Appeal']['status']),
				$appeal['Appeal']['default'] ? __('Yes', true) : __('No', true),
				$appeal['Appeal']['name'],
				$appeal['Appeal']['campaign_code'],
				$appeal['Appeal']['targeted_income'],
				$appeal['Appeal']['targeted_signups'],
				!empty($appeal['Template']['name'])
					? $appeal['Template']['name']
					: '--',
				$common->date($appeal['Appeal']['created']),
				$common->date($appeal['Appeal']['modified']),
				implode(' - ', $actions)
			));
			echo $html->tableCells($tr);
		}
		?>
		</table>
		<?php
		echo $form->end();
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