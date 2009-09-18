<?php if (isset($id) && isset($leaf) && !$leaf) : ?>
	<td class="fold"><a href="<?php echo Router::url(); ?>#" class="toggle close" id="toggle_<?php echo $id ?>">&nbsp;</a></td>
<?php elseif (isset($allowEmpty)) : ?>
	<td class="fold">&nbsp;</td>
<?php endif; ?>