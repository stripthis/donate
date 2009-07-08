<?php
Router::parseExtensions('js', 'json', 'xml', 'rss');
Router::connect('/', array('controller' => 'gifts', 'action' => 'wizard'));
Router::connect('/gifts/*', array('controller' => 'gifts', 'action' => 'wizard'));
Router::connect('/:language/:controller/:action/*', array(), array('language' => '[a-z]{3}'));
Router::connect('/users/add', array('controller' => 'users', 'action' => 'register'));
Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
Router::connect('/refer/*', array('controller' => 'users', 'action' => 'refer'));
Router::connect('/login', array('controller' => 'auth', 'action' => 'login'));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/admin', array('controller' => 'pages', 'action' => 'display', 'page'=>'home'));
Router::connect('/admin/home', array( 'controller' => 'pages','action' => 'display', 'admin_home', 'layout'=>'admin')); 
Router::connect('/about', array( 'controller' => 'pages','action' => 'display', 'about')); 
Router::connect('/news', array( 'controller' => 'posts','action' => 'index')); 
?>
