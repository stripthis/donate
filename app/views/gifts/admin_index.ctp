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
      <div class="paginator sort header">
      	<table>
      		<tr>
      			<td>&nbsp;</td>
      			<td>&nbsp;</td>
      			<td>&nbsp;</td>
      			<td class="favorites">&nbsp;</td>
      			<td class="status">&nbsp;</td>
      			<td class="name"><?php echo $paginator->sort(__('amount',true),'Gift.amount'); ?></td>
      			<td class="description">
      				<?php echo $paginator->sort(__('firstname',true),'Contact.fname'); ?> 
      				<?php echo $paginator->sort(__('last name',true),'Contact.lname'); ?>
      				(<?php echo $paginator->sort(__('email',true),'Contact.email'); ?>)
      			</td>
      			<td class="date"><?php echo $paginator->sort(__('date',true),'Gift.modified'); ?></td>
      			<td></td>
      		</tr>
      	</table>
      </div>
      <ul>
<?php foreach ($gifts as $gift): ?>
				<!-- header -->
				<li>
				<table class="gift">
<?php			echo $this->element('tableset/rows/gift', array('gift' => $gift, 'doFavorites'=>$doFavorites, 'folded'=>true)); ?>
        </table>
      	</li>
				<!-- folded sets -->
      	<li class="toggle_wrapper" id="wrapper_trigger_<?php echo $gift['Gift']['id'];?>">
      	<ul class="folded">
<?php 	if(isset($gift)): ?>
					<li>
					<table>
<?php			echo $this->element('tableset/rows/gift', array('gift'=>$gift, 'doFavorites'=>$doFavorites,'leaf'=>true)); ?>
					</table>
					</li>
<?php 	endif; ?>
<?php 	if(isset($gift['Contact'])): ?>
					<li>
					<table>
<?php			echo $this->element('tableset/rows/contact', array('contact'=>$gift, 'doFavorites'=>$doFavorites)); ?>
					</table>
					</li>
<?php 	endif; ?>
<?php 	foreach ($gift['Transaction'] as $transaction): ?>
					<li>
					<table>
<?php			echo $this->element('tableset/rows/transaction', array('transaction'=>$transaction, 'doFavorites'=>$doFavorites)); ?>
					</table>
					</li>
<?php 	endforeach; ?>
				</ul>
				</li>
<?php endforeach; ?>
			</ul>
      <?php echo $this->element('paging', array('model' => 'Gift'))?>
      <?php echo $this->element('../gifts/elements/filter'); ?>
    </div>
  </div>
