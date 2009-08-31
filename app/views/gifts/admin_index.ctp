<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Gift');
//pr($gifts);
?>
    <div class="content" id="gifts_index">
      <h2><?php __('Online Donations');?></h2>
<?php echo $this->element('../gifts/elements/menu'); ?>
<?php echo $this->element('../gifts/elements/actions'); ?>
      <div class="index_wrapper">
<?php //echo $this->element('/admin/css_tests/gift_index'); ?>
      	<table>
      		<thead>
      			<th class="select">&nbsp;</td>
      			<th class="fold">&nbsp;</td>
      			<th class="favorites">&nbsp;</td>
      			<th class="status">&nbsp;</td>
      			<th class="title"><?php echo $paginator->sort(__('amount',true),'Gift.amount'); ?></td>
      			<th class="description">
      				<?php echo $paginator->sort(__('firstname',true),'Contact.fname'); ?> 
      				<?php echo $paginator->sort(__('last name',true),'Contact.lname'); ?>
      				(<?php echo $paginator->sort(__('email',true),'Contact.email'); ?>)
      			</th>
      			<th class="attachments"></th>
      			<th class="comments"></th>
      			<th class="date"><?php echo $paginator->sort(__('date',true),'Gift.modified'); ?></td>
      			<th class="grab"></th>
      		</thead>
      		<tbody>
<?php
	foreach ($gifts as $gift) {
		echo $this->element('tableset/rows/gift', array('gift' => $gift, 'doFavorites'=>$doFavorites, 'folded'=>true));
		if(isset($gift)) {
			echo $this->element('tableset/rows/gift', array('gift'=>$gift, 'doFavorites'=>$doFavorites,'leaf'=>true));
			if(isset($gift['Contact'])) {
				echo $this->element('tableset/rows/contact', array('contact'=>$gift, 'doFavorites'=>$doFavorites)); 
			}
		 	foreach ($gift['Transaction'] as $transaction) {
				echo $this->element('tableset/rows/transaction', array('transaction'=>$transaction, 'doFavorites'=>$doFavorites));
			}
		}
	}
?>
				</tbody>
			</table>
      <?php echo $this->element('paging', array('model' => 'Gift'))?>
      <?php echo $this->element('../gifts/elements/filter'); ?>
    </div>
  </div>
