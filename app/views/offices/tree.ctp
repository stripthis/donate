<?php
if (empty($offices)) {
	return;
}

$depth = isset($depth) ? $depth : 1;
echo '<ul>';
foreach ($offices as $office) {
	echo '<li>' . $office['Office']['name'] . '</li>';
	echo $this->element('../offices/tree', array('offices' => $office['children'], 'depth' => $depth + 1));
}
echo '</ul>';
?>