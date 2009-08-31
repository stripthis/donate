<?php
header('Content-Type: text/javascript; charset: UTF-8');
Configure::write('debug', 0);
echo $content_for_layout;
?>