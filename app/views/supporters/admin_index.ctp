<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Gift');
$favConfig = Configure::read('Favorites');
?>
<div class="content" id="Supporters_index">
	<h2><?php echo __('Supporters', true);	?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'supporter_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
?>
<?php	echo $form->create('Gift', array('url' => '/admin/exports/supporters', 'type' => 'post')); ?>
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
			$myPaginator->sort(__('Name',true), 'Contact.lname', array('url' => $params)),
			$myPaginator->sort(__('Email',true), 'Contact.email', array('url' => $params)),
			__('Phone', true),
			__('Zip Code',true),
			__('City',true),
			__('Country',true),
			$myPaginator->sort(__('Created',true), 'Contact.created', array('url' => $params)),
			$myPaginator->sort(__('Modified',true), 'Contact.modified', array('url' => $params)),
			'Actions'
		));

		echo $html->tableHeaders($th);
		$canAddGifts = User::allowed('Gifts', 'admin_add');

		foreach ($supporters as $t) {
			$actions = array(
				$html->link(__('View', true), array(
					'action' => 'view', $t['Contact']['id']),array('class'=>'view'
				)),
				$html->link(__('Edit', true), array(
					'action' => 'edit', $t['Contact']['id']), array('class'=>'edit'
				))
			);

			if ($canAddGifts) {
				$actions[] = $html->link(__('Add Gift', true), array(
					'controller' => 'gifts', 'action' => 'add', $t['Contact']['id']),
					array('class'=>'add')
				);
			}

			$tr = array();
			$tr[] = $form->checkbox($t['Contact']['id'], array('class'=>'checkbox'));
			if ($doFavorites) {
				$tr[] = $favorites->link('Contact', $t['Contact']['id']);
			}
			$tr = am($tr,array(            
				$t['Contact']['fname'] . ' ' . $t['Contact']['lname'],
				$t['Contact']['email'],
				isset($t['Address'][0]['Phone'][0]['phone'])
					? $t['Address'][0]['Phone'][0]['phone']
					: '--',
				isset($t['Address'][0]['zip'])
					? $t['Address'][0]['zip']
					: '--',
				isset($t['Address'][0]['City']['name'])
					? $t['Address'][0]['City']['name']
					: '--',
				isset($t['Address'][0]['Country']['name'])
					? $t['Address'][0]['Country']['name']
					: '--',
				$common->date($t['Contact']['created']),
				$common->date($t['Contact']['modified']),
				implode(' - ', $actions)
			));
			echo $html->tableCells($tr);
		}
		?>
		</table>
	<?php echo $form->end(); ?>
		<?php
		$urlParams = $params;
		$urlParams[] = $type;
		unset($urlParams['ext']);
		unset($urlParams['page']);
		$urlParams['merge'] = true;
		echo $this->element('paging', array('model' => 'Contact', 'url' => $urlParams));
		?>
	<?php else : ?>
		<p class="nothing"><?php echo __('Sorry but there is nothing to display here...', true); ?></p>
	<?php endif; ?>
	<?php echo $this->element('../supporters/elements/filter', compact('params', 'type')); ?>
</div>