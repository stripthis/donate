<?php
  //pr($gifts);
  $options = array(
    'doFavorites' => class_exists('Favorite') && Favorite::doForModel('Gift'),
	  'model' => 'gift'
  );
  $urlParams = $params;
  $urlParams['merge'] = true;
  unset($urlParams['ext']);
  unset($urlParams['page']);
?>
    <div class="content" id="gifts_index">
      <h2><?php __('Online Donations');?></h2>
<?php echo $this->element('../gifts/elements/menu'); ?>
<?php echo $this->element('../gifts/elements/actions'); ?>
      <div class="index_wrapper">
		<?php
		unset($params['sort']);
		unset($params['direction']);
		?>
        <table>
          <thead>
          <tr>
            <th class="selection"><input name="Gift" class="select_all checkbox" type="checkbox"></th>
            <th class="fold">&nbsp;</th>
            <th class="favorites">&nbsp;</th>
            <th class="status">&nbsp;</th>
            <th class="title">
              <?php echo $myPaginator->sort(__('Amount',true), 'Gift.amount', array('url' => $params)); ?>
              <?php if ($type != 'onetime') : ?>
                <?php //@todo due date goes here) ?>
              <?php endif; ?>
            </th>
            <th class="description">
              <?php echo $myPaginator->sort(__('First Name',true),'Contact.fname', array('url' => $params)); ?> 
              <?php echo $myPaginator->sort(__('Last Name',true),'Contact.lname', array('url' => $params)); ?>
              <?php echo $myPaginator->sort(__('Email',true),'Contact.email', array('url' => $params)); ?>
            </th>
            <th class="attachments">&nbsp;</th>
            <th class="comments">&nbsp;</th>
            <th class="date"><?php echo $myPaginator->sort(__('date',true),'Gift.modified', array('url' => $params)); ?></th>
            <th class="grab"></th>
          </tr>
          </thead>
          <tbody>
<?php
  foreach ($gifts as $gift) {
    $options['parent_id'] = $gift['Gift']['id'];
    $options['gift'] = $gift;
    $options['leaf'] = 0;
    echo $this->element('tableset/rows/gift',$options);
    if(isset($gift)) {
    	$options['leaf'] = 1;
      echo $this->element('tableset/rows/gift', $options);
      if(isset($gift['Contact'])) {
        echo $this->element('tableset/rows/contact',am($options,array('contact'=>$gift))); 
      }
      foreach ($gift['Transaction'] as $transaction) {
        echo $this->element('tableset/rows/transaction', am($options, array('transaction'=>$transaction)));
      }
    }
  }
?>
        </tbody>
      </table>
    </div>
	  <?php	echo $this->element('paging', array('model' => 'Gift', 'url' => $urlParams));?>
    <?php echo $this->element('../gifts/elements/filter', compact('params')); ?>
  </div>
