<?php if(isset($leaf) && !$leaf): ?>
            <td class="selection"><?php echo $form->checkbox($id, array('class'=>'checkbox','name'=> $model));?></td>
<?php elseif(isset($allowEmpty) && $allowEmpty == true) : ?>
            <td class="selection">&nbsp;</td>
<?php endif; ?>
