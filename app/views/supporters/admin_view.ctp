<div class="content" id="Supporters_view">
	<h2><?php echo sprintf(__('Supporter: %s %s', true), $contact['Contact']['fname'], $contact['Contact']['lname']); ?></h2>
	<dl>
		<dt><?php echo __('Id', true); ?></dt>
		<dd>
			<?php echo $contact['Contact']['id']; ?>
		</dd>
		<dt><?php echo __('Fname', true); ?></dt>
		<dd>
			<?php echo $contact['Contact']['fname']; ?>
		</dd>
		<dt><?php echo __('Lname', true); ?></dt>
		<dd>
			<?php echo $contact['Contact']['lname']; ?>
		</dd>
		<dt><?php echo __('Salutation', true); ?></dt>
		<dd>
			<?php echo $contact['Contact']['salutation']; ?>
		</dd>
		<dt><?php echo __('Title', true); ?></dt>
		<dd>
			<?php echo $contact['Contact']['title']; ?>
		</dd>
		<dt><?php echo __('Address', true); ?></dt>
		<dd>
			<?php echo $contact['Address'][0]['line_1']; ?><br />
			<?php echo $contact['Address'][0]['line_2']; ?>
		</dd>
		<dt><?php echo __('Zip', true); ?></dt>
		<dd>
			<?php echo $contact['Address'][0]['zip']; ?>
		</dd>
		<dt><?php echo __('Country', true); ?></dt>
		<dd>
			<?php echo $contact['Address'][0]['Country']['name']; ?>
		</dd>
		<dt><?php echo __('Email', true); ?></dt>
		<dd>
			<?php echo $contact['Contact']['email']; ?>
		</dd>
		<dt><?php echo __('Created', true); ?></dt>
		<dd>
			<?php echo $common->date($contact['Contact']['created']); ?>
		</dd>
		<dt><?php echo __('Last Update', true); ?></dt>
		<dd>
			<?php echo $contact['Contact']['modified']; ?>
		</dd>
	</dl>

	<h2><?php echo __('Gifts', true); ?></h2>
	<?php
	$gifts = $contact['Gift'];
	?>
	<?php if (!empty($gifts)) : ?>
		<div class="index_wrapper">
			<table>
				<thead>
					<tr>
						<th class="status">&nbsp;</th>
						<th class="title">
							<?php echo __('Amount', true); ?>
							<?php echo __('Frequency', true); ?>
							<?php echo __('Due', true); ?>
						</th>
						<th class="attachments">&nbsp;</th>
						<th class="comments">&nbsp;</th>
						<th class="date"><?php echo __('Date', true); ?></th>
						<th class="grab"></th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ($gifts as $gift) : ?>
						<?php
						$gift = array('Gift' => $gift);
						$class = 'gift';
						$gift['Gift']['status'] = $common->giftStatus($gift);

						// recurring options for collumns elements
						$options = array(
							'model'=> 'Gift', 
							'id'=> $gift['Gift']['id'],
							'status' => $gift['Gift']['status'],
							'allowEmpty' => (isset($allowEmpty) ? $allowEmpty : true),
							'leaf' => false,
							'parent_id' => isset($parent_id) ? $parent_id : false
						);
						?>

						<tr class="<?php echo $common->getFoldClass($options); ?>">
							<?php echo $this->element('tableset/collumns/status', $options); ?>
							<td class="title gift details" >
								<span class="iconic gift creditcard">
									<?php echo $gift['Gift']['amount'] . ' EUR ' . $gift['Gift']['frequency']; ?>
								</span>
								#<?php echo $gift['Gift']['serial']?>
								(<?php echo __('due',true) ?>: <?php echo $gift['Gift']['due'] ? __('yes',true) : __('no',true)?>)
							</td>

							<?php echo $this->element('tableset/collumns/attachments', $options); ?>
							<?php echo $this->element('tableset/collumns/comments', $options); ?>
							<?php echo $this->element('tableset/collumns/date', array('date' => $gift['Gift']['modified'])); ?>
							<?php echo $this->element('tableset/collumns/grab'); ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php else : ?>
		<p class="nothing"><?php echo __('Sorry but there is nothing to display here...', true); ?></p>
	<?php endif; ?>
</div>