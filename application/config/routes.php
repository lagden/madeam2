<?php
//
// Admin Routes
//
// Pages
madeam\Router::connect(':_controller/page/:pagina/:id',array('_action' =>'page'),array('_controller' => 'admin\/[^\/]+','pagina'=>'\d+','id'=>'\d+'));
madeam\Router::connect(':_controller/page/:pagina',array('_action' =>'page'),array('_controller' => 'admin\/[^\/]+','pagina'=>'\d+'));
// Busca
madeam\Router::connect(':_controller/busca/:busca',array('_action' =>'busca'),array('_controller' => 'admin\/[^\/]+','busca'=>'.*'));
// Geral
madeam\Router::connect(':_controller/:_action/:id',array(), array('_controller' => 'admin\/[^\/]+'));
madeam\Router::connect('admin',array('_controller'=>'admin/index'),array());

//
// Default
//
madeam\Router::connect(':_controller/:_action/:id', array(), array('id' => '\d+'));
madeam\Router::connect(':_controller/:_action');
