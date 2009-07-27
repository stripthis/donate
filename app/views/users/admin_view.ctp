<h1><?php echo $this->pageTitle = 'Details for ' . $user['User']['login']; ?></h1>

<?php echo $html->link('&laquo; Back to Users', array('controller' => 'users', 'action' => 'index', 'admin' => 'true'), null, false, false)?>