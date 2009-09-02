<?php if(isset($links)) :  ?>
<?php 
  if(!isset($selected)) {
    $selected = false;
  }
?>
      <div class="actions">
        <h3><?php __('Actions') ?></h3>
        <ul>
<?php foreach($links as $link): ?>
<li>
<?php
          if($selected!=false) {
            if(!isset($link['option']['class'])) {
              $link['options']['class'] = '';
            }
            $link['options']['class'] .= ($selected == $link['label'] || $selected == $link['name']) ? "selected" : '';
          }
          echo $html->link($link['name'], $link['uri'], $link['options']);
?>
          </li>
<?php endforeach; ?>
         </ul>
      </div>
<?php endif; ?>
