<?php if (isset($leaf) && !$leaf): ?>
	<td class="selection"><?php echo $form->checkbox($model . '.' . $id, array('class'=>'checkbox'));?></td>
<?php elseif (isset($allowEmpty) && $allowEmpty == true) : ?>
	<td class="selection">&nbsp;</td>
<?php endif; ?>