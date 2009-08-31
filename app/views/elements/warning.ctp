<?php
$txt = isset($txt) ? $txt : __('Sorry, nothing to list.',true);
$class = isset($class) ? $class : 'warning';
?>
<div class="msg_empty"><span class="<?php echo $class ?>"><?php echo $txt ?></span></div>