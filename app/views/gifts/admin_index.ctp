<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Gift');
$favConfig = Configure::read('Favorites');
//pr($gifts);
?>
    <div class="content" id="gifts_index">
      <h2><?php __('Online Donations');?></h2>
<?php echo $this->element('../gifts/elements/menu'); ?>
<?php echo $this->element('../gifts/elements/actions'); ?>
      <div class="index_wrapper">
      <ul>
      <li>
        <table class="gift">
          <tr id="">
            <td class="selection"><input type="hidden" name="data[4a8d52e3-838c-4700-84a1-1b1b7f000102]" id="4a8d52e3-838c-4700-84a1-1b1b7f000102_" value="0" /><input type="checkbox" name="data[4a8d52e3-838c-4700-84a1-1b1b7f000102]" class="checkbox" value="1" id="4a8d52e3-838c-4700-84a1-1b1b7f000102" /></td>
            <td class="favorites"><a href="/admin/favorites/add/4a8d52e3-838c-4700-84a1-1b1b7f000102/Gift" class="star"><img src="/img/icons/S/rate.png" alt="Star" /></a></td>
            <td class="fold"><a href="<?php echo Router::url(); ?>#" class="toggle close" id="trigger_4a8d52e3-838c-4700-84a1-1b1b7f000102">&nbsp;</a></td>
            <td class="amount">10</td>
            <td class="currency">EUR </td>
            <td class="frequency">monthly</td>
            <td class="name">
              <a href="/admin/supporters/view/4a8d52e3-13c8-4cc1-87bb-1b1b7f000102">
                Remy Bertot 
                (remy@stripthis.com)
              </a>
            </td>
            <td class="notifications">
              <img src="/img/icons/S/attach.png" alt="" />
              <img src="/img/icons/S/comments.png" alt="" />
            </td>
            <td class="date">Aug 20th, 15:42</td>
            <td class="grab">
              <a href="/admin/gifts/index#">&nbsp;</a>
            </td>
          </tr>
        </table>  
      </li>
      <li class="toggle_wrapper" id="wrapper_trigger_4a8d52e3-838c-4700-84a1-1b1b7f000102">
        <ul class="folded">
        <li>
			  <table class="profile">
          <tr id='4a8d52e3-13c8-4cc1-87bb-1b1b7f000102'>
            <td class="favorites"><a href="/admin/favorites/add/4a8d52e3-838c-4700-84a1-1b1b7f000102/Gift" class="star"><img src="/img/icons/S/rate.png" alt="Star" /></a></td>
            <td class="name">
              <a href="/admin/supporters/view/4a8d52e3-13c8-4cc1-87bb-1b1b7f000102" class="iconic profile">
                Remy Bertot 
              </a>
            </td>
            <td class="email>
                (remy@stripthis.com)
            </td>
            <td class="notifications">
              <img src="/img/icons/S/attach.png" alt="" />
              <img src="/img/icons/S/comments.png" alt="" />
            </td>
            <td class="date">Aug 20th, 15:42</td>
            <td class="grab">
              <a href="/admin/gifts/index#">&nbsp;</a>
            </td>
          </tr>
        </table> 
        </li>
        <li>
        <table class="transaction">
          <tr id='4a8d52e3-13c8-4cc1-87bb-1b1b7f000102'>
            <td class="favorites"><a href="/admin/favorites/add/4a8d52e3-838c-4700-84a1-1b1b7f000102/Gift" class="star"><img src="/img/icons/S/rate.png" alt="Star" /></a></td>
            <td class="transaction">
              <a href="/admin/supporters/view/4a8d52e3-13c8-4cc1-87bb-1b1b7f000102" class="iconic transaction">
                ger56g4e63rg4eg
              </a>
            </td>
            <td class="bank">
               Bibit Payment Gateway
            </td>
            <td class="notifications">
              <img src="/img/icons/S/attach.png" alt="" />
              <img src="/img/icons/S/comments.png" alt="" />
            </td>
            <td class="date">Aug 20th, 15:42</td>
            <td class="grab">
              <a href="/admin/gifts/index#">&nbsp;</a>
            </td>
          </tr>
        </table> 
        </li>
        </ul>
      </li>
      </ul>
			<table>
<?php foreach ($gifts as $gift): ?>
          <tr class="gift" id='<?php echo $gift['Gift']['id'];?>'>
            <td class="checkbox"><?php echo $form->checkbox($gift['Gift']['id'], array("class"=>"checkbox"));?></td>
            <td class="favorites"><?php 
                // star / favorites
                if ($doFavorites) {
                  echo $html->link(
                    $html->image('/img/icons/S/rate.png', array('alt'=>__(ucfirst($favConfig['verb']), true))), 
                    array('controller' => 'favorites', 'action' => 'add', $gift['Gift']['id'], 'Gift'),
                    array('class' => 'star', 'escape'=>false)
                  );
                }
              ?></td>
            <td class="fold"><a href="<?php echo Router::url(); ?>#">show/hide</a></td>
            <td class="amount"><?php echo $gift['Gift']['amount'];?></td>
            <td class="currency">EUR <?php //@todo currencies?></td>
            <td class="frequency"><?php echo $gift['Gift']['frequency'];?></td>
            <td class="name">
              <a href="<?php echo Router::url('/admin/supporters/view/').$gift['Gift']['contact_id']; ?>">
                <?php echo ucfirst($gift['Contact']['fname']);?> <?php echo ucfirst($gift['Contact']['lname']);?> 
                (<?php echo low($gift['Contact']['email']);?>)
              </a>
            </td>
            <td class="notifications">
              <?php echo $html->image('icons/S/attach.png', array('alt'=>__('this record contain an attachment',true)))."\n"; //@todo if attachment only ?>
              <?php echo $html->image('icons/S/comments.png', array('alt'=>__('this record contain comments',true)))."\n"; //@todo if comment only ?>
            </td>
            <td class="date"><?php echo $time->niceShort($gift['Gift']['created']);?></td>
            <td class="grab">
              <a href="<?php echo Router::url(); ?>#">&nbsp;</a>
            </td>
          </tr>
<?php endforeach; ?>
        </tbody>
        </table>
      <?php echo $this->element('paging', array('model' => 'Gift'))?>
      <?php echo $this->element('../gifts/elements/filter'); ?>
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
