<?php 
  if(!isset($selected)) {
    $selected = false;
  }
?>
      <div class="actions">
        <h3><?php echo __('Actions', true); ?></h3>
        <ul>
<?php if(isset($links) && !empty($links)) :  ?>
<?php foreach($links as $link): ?>
          <li>
          <?php
          if(!isset($link['submit'])) {
	          if($selected!=false) {
	            if(!isset($link['option']['class'])) {
	              $link['options']['class'] = '';
	            }
	            $link['options']['class'] .= ($selected == $link['label'] || $selected == $link['name']) ? "selected" : '';
	          }
	          echo $html->link($link['name'], $link['uri'], $link['options']);
          } else {
					  if(!isset($link['options'])) {
							$link['options'] = array();
						}
          	echo $form->submit($link['name'], $link['options']);
          }
          ?>
          </li>
<?php endforeach; ?>
<?php else: ?>
          <li class="nothing">
          	<p><?php echo __('Sorry, but there is nothing to do here for now', true); ?></p>
          </li>
<?php endif; ?>
         </ul>
      </div>
