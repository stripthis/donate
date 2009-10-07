<?php if (true || isset($model) && isset($id)) : ?>
	<td class="favorites"><?php echo $favorites->link($model, $id); ?></td>
<?php endif; ?>