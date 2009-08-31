<div class="content" id="appeals view">
<h2><?php  __('Appeal');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Edit Appeal', true), array('action'=>'edit', $appeal['Appeal']['id']), array('class'=>'edit')); ?> </li>
      <li><?php echo $html->link(__('Delete Appeal', true), array('action'=>'delete', $appeal['Appeal']['id']),  array('class'=>'delete'), sprintf(__('Are you sure?', true), $appeal['Appeal']['id'])); ?> </li>
      <li><?php echo $html->link(__('Appeal List', true), array('action'=>'index'),array('class'=>'index')); ?> </li>
    </ul>
  </div>
	<dl>
    <dt><?php __('Id'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['id']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Parent'); ?></dt>
    <dd>
      <?php echo $html->link($appeal['Parent']['name'], array('controller'=> 'appeals', 'action'=>'view', $appeal['Parent']['id'])); ?>
      &nbsp;
    </dd>
    <dt><?php __('Name'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['name']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Campaign Code'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['campaign_code']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Default'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['default']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Starred'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['starred']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Cost'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['cost']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Reviewed'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['reviewed']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Status'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['status']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Country'); ?></dt>
    <dd>
      <?php echo $html->link($appeal['Country']['name'], array('controller'=> 'countries', 'action'=>'view', $appeal['Country']['id'])); ?>
      &nbsp;
    </dd>
    <dt><?php __('User'); ?></dt>
    <dd>
      <?php echo $html->link($appeal['User']['login'], array('controller'=> 'users', 'action'=>'view', $appeal['User']['id'])); ?>
      &nbsp;
    </dd>
    <dt><?php __('Created'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['created']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Modified'); ?></dt>
    <dd>
      <?php echo $appeal['Appeal']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
</div>

