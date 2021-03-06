<?php
Router::parseExtensions('js', 'json', 'xml', 'rss', 'pdf', 'csv');
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
Router::connect('/:language/:controller/:action/*', array(), array('language' => '[a-z]{3}'));
//Router::connect('/users/add', array('controller' => 'users', 'action' => 'register'));
//Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
//Router::connect('/login', array('controller' => 'auth', 'action' => 'login'));
Router::connect('/refer/*', array('controller' => 'users', 'action' => 'refer'));
Router::connect('/bibit/redirect/choose/*', array('controller' => 'bibit', 'action' => 'result', 'plugin' => 'bibitfake'));
Router::connect('/bibit/pass/*', array('controller' => 'bibit', 'action' => 'pass', 'plugin' => 'bibitfake'));
Router::connect('/worldpay_sample', array('controller' => 'pages', 'action' => 'display', 'worldpay_sample'));
Router::connect('/tellafriend', array('plugin' => 'tellfriends', 'controller' => 'tellfriends', 'action' => 'refer'));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/admin/login', array('controller' => 'auth', 'action'=>'login', 'admin'=>1));
Router::connect('/admin', array('controller' => 'statistics', 'action' => 'index', 'admin' => 1));
Router::connect('/admin/home', array('controller' => 'dashboards', 'action' => 'index', 'admin' => 1));
Router::connect('/admin/help', array('controller' => 'pages', 'action' => 'display', 'page'=>'start', 'admin'=>1));
Router::connect('/admin/help/*', array('controller' => 'pages', 'action' => 'display', 'admin'=>1));
Router::connect('/admin/logs/*', array('controller' => 'logs', 'admin'=> 1, 'plugin' => 'logging'));
?>