<?php
Configure::write('debug', 0);
header('Content-type: text/plain');
echo $content_for_layout;
?>