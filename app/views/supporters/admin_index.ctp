<?php
	$doFavorites = class_exists('Favorite') && Favorite::doForModel('supporter');
	$favConfig = Configure::read('Favorites');
?>
  <div class="content" id="Supporters_index">
    <h2><?php __('Supporters', true);	?></h2>
<?php
	echo $this->element('nav', array(
		'type' => 'supporter_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
?>
<?php echo $form->create('supporter', array('url' => '/admin/exports/supporters', 'type' => 'post')); ?>
<?php echo $this->element('../supporters/elements/actions', array('export' => true)); ?>
<?php if (!empty($supporters)) : ?>
	<table>
	<?php
	unset($params['sort']);
	unset($params['direction']);
	$th = array();
	$th[] = '<input name="supporter" class="select_all checkbox" type="checkbox">';
	if ($doFavorites) {
		$th[] = $favorites->favall();
	}
	$th = am($th,array(
		$myPaginator->sort(__('Status',true),'supporter.status', array('url' => $params)),
		$myPaginator->sort(__('Id',true),'supporter.serial', array('url' => $params)),
		$myPaginator->sort(__('External ID',true),'supporter.external_id', array('url' => $params)),
		//$myPaginator->sort(__('Parent',true),'supporter.parent_id', array('url' => $params)),
		$myPaginator->sort(__('Amount',true),'supporter.amount', array('url' => $params)),
		$myPaginator->sort(__('Gateway',true),'Gateway.parent_id', array('url' => $params)),
		$myPaginator->sort(__('Gift',true),'supporter.gift_id', array('url' => $params)),
		$myPaginator->sort(__('Created',true),'supporter.created', array('url' => $params)),
		$myPaginator->sort(__('Modified',true),'supporter.modified', array('url' => $params)),
		'Actions'
	));

	echo $html->tableHeaders($th);
	foreach ($Supporters as $t) {
		$actions = array(
			$html->link(__('View', true), array(
				'action' => 'view', $t['supporter']['id']),array('class'=>'view'
			)),
			$html->link(__('Delete', true), array('action' => 'delete', $t['supporter']['id']),
				array('class'=>'delete'), __('Are you sure?', true))
		);
		
		$parent = '';
		if (!empty($t['Parentsupporter']['id'])) {
			$parent = $html->link($t['Parentsupporter']['id'], array(
				'controller' => 'Supporters', 'action' => 'view', $t['Parentsupporter']['id']
			));
		}

		$gift = $html->link('Check', array('controller'=> 'gifts', 'action'=>'view', $t['Gift']['id']));
		$tr = array();
		$tr[] = $form->checkbox($t['supporter']['id'], array('class'=>'checkbox'));
		if ($doFavorites) {
			$tr[] = $favorites->link("supporter", $t['supporter']['id']);
		}
		$tr = am($tr,array(            
			$t['supporter']['status'],
			$t['supporter']['serial'],
			$t['supporter']['external_id'],
			//$parent,
			$t['supporter']['amount'].' EUR', //@todo currency
			$t['Gateway']['name'],
			$gift,
			$t['supporter']['created'],
			$t['supporter']['modified'],
			implode(' - ', $actions)
		));
		echo $html->tableCells($tr);

		if (!empty($t['Childsupporter'])) {
			foreach ($t['Childsupporter'] as $t) {
				$actions = array(
					$html->link(__('View', true), array(
						'action' => 'view', $t['supporter']['id']), array('class' => 'view'
					)),
					$html->link(__('Delete', true), array(
						'action' => 'delete', $t['supporter']['id']), array('class' => 'delete'),
						__('Are you sure?', true))

				);
				$id = $html->link($t['supporter']['id'], array(
					'controller' => 'Supporters', 'action' => 'view', $t['supporter']['id']
				));
				$tr = array(
					$t['supporter']['status'],
					$id,
					$t['Gateway']['name'],
					$t['supporter']['amount'],
					$t['supporter']['external_id'],
					$gift,
					$t['supporter']['created'],
			    $t['supporter']['modified'],
					$actions
				);
			}
		}
	}
	?>
	</table>
	<?php
	echo $form->end();
	$urlParams = $params;
	$urlParams[] = $type;
	unset($urlParams['ext']);
	unset($urlParams['page']);
	$urlParams['merge'] = true;
	echo $this->element('paging', array('model' => 'supporter', 'url' => $urlParams));
	?>
<?php else : ?>
    <p class="nothing"><?php echo __('Sorry but there is nothing to display here...'); ?></p>
<?php endif; ?>
<?php echo $this->element('../supporters/elements/filter', compact('params', 'type')); ?>
</div>
