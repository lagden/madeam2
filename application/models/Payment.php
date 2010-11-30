<?php
namespace models;
use \ActiveRecord\Model as ARM;
class Payment extends ARM{
	
	static $belongs_to=array(
		array('user','class'=>'models\User'),
		array('order','class'=>'models\Order')
	);
	
	// static $belongs_to=array(
	// 	array('user'),
	// 	array('order')
	// );

}