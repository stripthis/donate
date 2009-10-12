<div class="content" id="templates_index">
	<h2><?php echo __('Templates', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'template_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
<?php if (isset($templates) && !empty($templates)) : ?>
		<div class="index_wrapper">
			<table>
				<thead>
					<tr>
						<th class="published">
							<?php echo $myPaginator->sort(__('Published', true), 'Template.published'); ?>
						</th>
						<th class="title">
							<?php echo $myPaginator->sort(__('Title', true), 'Template.name'); ?>
						</th>
						<th><?php echo $myPaginator->sort(__('Number of Steps', true), 'Template.template_step_count'); ?></th>
						<th class="date"><?php echo $myPaginator->sort(__('Created', true), 'Template.created'); ?></th>
						<th><?php __('Actions') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($templates as $template) {
						$actions = array(
							$html->link(__('Edit', true), array('action' => 'edit', $template['Template']['id'])),
							$html->link(__('Publish', true), array('action' => 'publish', $template['Template']['id'])),
							$html->link(__('Delete', true),
								array('action' => 'delete', $template['Template']['id']), null,
								'Are you sure?'
							),
						);

						$tr = array(
							$template['Template']['published'] ? __('Yes', true) : __('No', true),
							$template['Template']['name'],
							$template['Template']['template_step_count'],
							$common->date($template['Template']['created']),
							implode(' - ', $actions)
						);
						echo $html->tableCells($tr);
					}
					?>
				</tbody>
			</table>
		</div>
		<?php echo $this->element('paging', array('model' => 'Template')); ?>
	<?php else : ?>
		<p class="nothing"><?php echo __('Sorry but there is nothing to display here...', true); ?></p>
	<?php endif; ?>
</div>