<div class="gifts view">
<h2><?php  __('Gift');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete Gift', true), array('action'=>'delete', $gift['Gift']['id']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $gift['Gift']['id'])); ?> </li>
    </ul>
  </div>
	<dl>
    <dt><?php __('Id'); ?></dt>
    <dd>
      <?php echo $gift['Gift']['id']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Office'); ?></dt>
    <dd>
      <?php echo $html->link($gift['Office']['name'], array('controller'=> 'offices', 'action'=>'view', $gift['Office']['id'])); ?>
      &nbsp;
    </dd>
    <dt><?php __('Type'); ?></dt>
    <dd>
      <?php echo $gift['Gift']['type']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Amount'); ?></dt>
    <dd>
      <?php echo $gift['Gift']['amount']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Description'); ?></dt>
    <dd>
      <?php echo $gift['Gift']['description']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Frequency'); ?></dt>
    <dd>
      <?php echo $gift['Gift']['frequency']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Appeal'); ?></dt>
    <dd>
      <?php echo $html->link($gift['Appeal']['name'], array('controller'=> 'appeals', 'action'=>'view', $gift['Appeal']['id'])); ?>
      &nbsp;
    </dd>
    <dt><?php __('Fname'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['fname']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Lname'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['lname']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Salutation'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['salutation']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Title'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['title']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Address'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['Address'][0]['line_1']; ?><br />
      <?php echo $gift['Contact']['Address'][0]['line_2']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Zip'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['Address'][0]['zip']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Country'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['Address'][0]['Country']['name']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Email'); ?></dt>
    <dd>
      <?php echo $gift['Contact']['email']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Created'); ?></dt>
    <dd>
      <?php echo $gift['Gift']['created']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Modified'); ?></dt>
    <dd>
      <?php echo $gift['Gift']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
</div>

<?php echo $this->element('comments', array('item' => $gift, 'items' => $comments, 'plugin' => 'Comments'))?>