<div class="content edit" id="users_edit">
	<h2><?php echo $this->pageTitle = __('Email Reports', true); ?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'user_preferences', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<h2><?php echo __('Available Reports', true); ?></h2>
	<?php
	echo $form->create('User', array('url' => $this->here));
	?>
	<div class="index_wrapper">
		<table>
			<thead>
				<tr>
					<th class="selection"><input name="Report" class="select_all checkbox" type="checkbox"></th>
					<th><?php echo $myPaginator->sort(__('Title',true), 'title'); ?></th>
					<th><?php echo $myPaginator->sort(__('File Name Format', true), 'filename'); ?></th>
					<th><?php echo $myPaginator->sort(__('Frequency', true), 'frequency'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($reports as $report) : ?>
					<tr>
						<td class="selection">
							<?php
							$checked = in_array($report['Report']['id'], $myReports);
							echo $form->checkbox('User.reports.' . $report['Report']['id'], array(
								'class' => 'checkbox', 'checked' => $checked ? 'checked' : ''
							));
							?>
						</td>
						<td class="title details" >
							<?php echo $report['Report']['title']?>
						</td>
						<td class="title details" >
							<?php echo $report['Report']['filename']?>
						</td>
						<td class="title details" >
							<?php echo ucfirst($report['Report']['frequency'])?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
	echo $form->end('Save');
	?>
</div>