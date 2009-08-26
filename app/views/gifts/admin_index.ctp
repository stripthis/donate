<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Gift');
$favConfig = Configure::read('Favorites');
//pr($gifts);

?>
    <div class="content" id="gifts_index">
      <h2><?php __('Online Donations');?></h2>
      <?php echo $this->element('../gifts/elements/menu'); ?>
      <?php echo $this->element('../gifts/elements/filter'); ?>
      <div class="index_wrapper">
        <table>
        <tbody>
<?php foreach ($gifts as $gift): ?>
      		<tr>
      			<td class="grab">
              <a href="<?php echo Router::url(); ?>#">&nbsp;</a>
            </td>
      			<td class="checkbox">
              <?php echo $form->checkbox($gift['Gift']['id'], array("class"=>"checkbox"));?>
            </td>
            <td class="favorites">
      			<?php 
				// star / favorites
				if ($doFavorites) {
					$isFavorited = ClassRegistry::init('Favorite')->isFavorited($gift['Gift']['id']);
					if (!$isFavorited) {
						$img = $html->image('/img/icons/S/rate.png', array('alt'=>__(ucfirst($favConfig['verb']), true)));
						echo $html->link($img, array(
							'controller' => 'favorites', 'action' => 'add', $gift['Gift']['id'], 'Gift'
							), array('class' => 'star', 'escape'=>false
						));
					} else {
						$img = $html->image('/img/icons/S/rate.png', array('alt'=>__(ucfirst($favConfig['verb']), true)));
						echo $html->link($img, array(
							'controller' => 'favorites', 'action' => 'delete', $gift['Gift']['id'], 'Gift'
							), array('class' => 'star', 'escape'=>false
						));
					}
				}
            ?>
            <?php //echo $html->image('/img/icons/S/bullet_green.png'); ?>
            </td>
            <td class="amount">
              <?php //echo $gift['Gift']['type'];?>
              <?php echo $gift['Gift']['amount'];?>
            </td>
            <td class="currency">
              EUR <?php //@todo currencies?>
            </td>
            <td class="frequency">
              <?php echo $gift['Gift']['frequency'];?>
            </td>
            <td class="body">
              <a href="<?php echo Router::url('/admin/gifts/view/') . $gift['Gift']['id'] ; ?>">
                <?php echo ucfirst($gift['Contact']['fname']);?>
                <?php echo ucfirst($gift['Contact']['lname']);?> 
                (<?php echo low($gift['Contact']['email']);?>)
              </a>
            </td>
            <td class="notifications">
              <?php echo $html->image('icons/S/attach.png'); //@todo if attachment only ?>
              <?php echo $html->image('icons/S/comments.png'); //@todo if comment only ?>
            </td>
            <td class="date">
            <?php echo $time->niceShort($gift['Gift']['created']);?>
            </td>
      		</tr>
<?php endforeach; ?>
				</tbody>
      	</table>
    <?php echo $this->element('paging', array('model' => 'Gift'))?>
    <div class="actions">
      <h3>Actions</h3>
      <ul>
        <li><a href="/admin/group_delete" class="delete" onclick="return confirm('Are you sure you want to delete # 4a6458a6-6ea0-4080-ad53-4a89a7f05a6e?');">Delete</a></li>
        <li><a href="/admin/group_edit" class="edit">New Donation</a></li>
        <?php 
        	/* @todo add from admin 
        	<li><a href="/admin/gift/add" class="add donation">Add Donation</a></li>*/
        ?>
       </ul>
    </div>
    </div>
  </div>
<?php /*
        $th = array(
          $paginator->sort('office_id'),
          $paginator->sort('type'),
          $paginator->sort('amount'),
          $paginator->sort('frequency'),
          $paginator->sort('appeal_id'),
          $paginator->sort('fname'),
          $paginator->sort('lname'),
          $paginator->sort('email'),
          $paginator->sort('created'),
          'Actions'
        );
        echo $html->tableHeaders($th);
        foreach ($gifts as $gift) {
          $actions = array(
            $html->link(__('View', true), array('action'=>'view', $gift['Gift']['id']),array('class'=>'view')),
            $html->link(__('Delete', true), array(
              'action' => 'delete', $gift['Gift']['id']), array('class' => 'delete'), 'Are you sure?')
          );
          if ($doFavorites) {
            $actions[] = $html->link(__(ucfirst($favConfig['verb']), true), array(
              'controller' => 'favorites', 'action' => 'add', $gift['Gift']['id'], 'Gift'
            ));
          }
          $office = $html->link($gift['Office']['name'], array(
            'controller' => 'offices', 'action' => 'view', $gift['Office']['id']
          ));
          $appeal = $html->link($gift['Appeal']['name'], array(
            'controller' => 'appeals', 'action'=>'view', $gift['Appeal']['id']
          ));
          $tr = array(
            $office,
            $gift['Gift']['type'],
            $gift['Gift']['frequency'],
            $gift['Gift']['amount'],
            $appeal,
            $gift['Contact']['fname'],
            $gift['Contact']['lname'],
            $gift['Contact']['email'],
            $gift['Gift']['created'],
            implode(' - ', $actions)
          );
          echo $html->tableCells($tr);
        }*/
?>
