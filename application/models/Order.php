<?php
namespace models;
use \ActiveRecord\Model as ARM;
class Order extends ARM{
	
	static $has_many=array(
		array('payments','class'=>'models\Payment')
	);
	
	static $has_one = array(
		array('payments','class'=>'models\Payment'),
		array('user','class'=>'models\User','through'=>'payments','throughClass'=>'models\Payment')
	);
	
	// static $has_many=array(
	// 	array('payments')
	// );
	// 
	// static $has_one = array(
	// 	array('payments'),
	// 	array('user','through'=>'payments')
	// );
}