<?php
  // if not a leaf then wrap!
  $class = "gift";
  $id = "";
  if(!isset($leaf)) {
    $leaf=0;
  }
  //@todo somewhere else?
  //determine overall gift status based on sub objects
  $gift['Gift']['status'] = 'tick';
  if(!isset($gift['Contact']) && !isset($gift['Transaction'])) {
    $gift['Gift']['status'] = 'error';
  }else{
    foreach($gift['Transaction'] as $transaction){
      if($transaction['status'] == 'new' && !$leaf && $gift['Gift']['status']!='warning') {
         $gift['Gift']['status'] = 'new';
      }elseif($transaction['status'] == 'warning'){
        $gift['Gift']['status'] = 'warning';
      }elseif($transaction['status'] == 'error'){
        $gift['Gift']['status'] = 'error';
        break;
      }
    }
  }
  // recurring options for collumns elements
  $options = array(
    'model'=>'Gift', 
    'id'=> $gift['Gift']['id'],
    'status' => $gift['Gift']['status'],
    'allowEmpty' => (isset($allowEmpty) ? $allowEmpty : true),
    'leaf' => $leaf,
  	'parent_id' => isset($parent_id) ? $parent_id : false
  );
?>
          <tr class="<?php echo $common->getFoldClass($options); ?>">
<?php echo $this->element('tableset/collumns/selection', $options); ?>
<?php echo $this->element('tableset/collumns/fold', $options); ?>
<?php echo $this->element('tableset/collumns/favorites',$options); ?>
<?php echo $this->element('tableset/collumns/status', $options); ?>
            <td class="title gift details" >
              <a href="<?php echo Router::url('/admin/gifts/view/') . $gift['Gift']['id']; ?>" class="iconic gift creditcard">
                <?php echo $gift['Gift']['amount'];?> EUR <?php //@todo currencies?> <?php echo $gift['Gift']['frequency'];?>

              </a>
<?php if(!isset($leaf) || $leaf==false): ?>
              #<?php echo $gift['Gift']['serial']?>
<?php if ($type != 'onetime') : ?>
              (<?php echo __('due',true) ?>: <?php echo $gift['Gift']['due'] ? __('yes',true) : __('no',true)?>)
<?php endif; ?>
<?php endif; ?>
            </td>
<?php if(!isset($leaf) || $leaf==false): ?>
            <td class="description contact details">
              <a href="<?php echo Router::url('/admin/gifts/view/') . $gift['Gift']['id'] ; ?>">
                <?php echo ucfirst($gift['Contact']['fname']);?> <?php echo ucfirst($gift['Contact']['lname']);?> 
                (<?php echo low($gift['Contact']['email']);?>)
              </a>
            </td>
<?php else: ?>
            <td class="description">
               Some more information <?php //@dynamic ?>
            </td>
<?php endif; ?>
<?php echo $this->element('tableset/collumns/attachments',$options); ?>
<?php echo $this->element('tableset/collumns/comments',$options); ?>
<?php echo $this->element('tableset/collumns/date', array('date'=>$gift['Gift']['modified'])); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
          </tr>
