<?php
namespace models;
use \ActiveRecord\Model as ARM;
class User extends ARM{
	
	static $has_many=array(
		array('payments','class'=>'models\Payment'),
		array('orders','class'=>'models\Order','through'=>'payments','throughClass'=>'models\Payment')
	);
	
	// static $has_many=array(
	// 	array('payments'),
	// 	array('orders','through'=>'payments')
	// );
	
	/*
	static $validates_presence_of = array(
		array('login', 'message' => 'O campo "LOGIN" não pode ser nulo.'),
		array('email', 'message' => 'O campo "EMAIL" não pode ser nulo.'),
		array('password', 'message' => 'O campo "PASSWORD" não pode ser nulo.')
	);
	
	static $validates_size_of = array(
		array(
			'name', 'within' => array(3,50),
			'too_long' => 'O campo "NOME" está muito longo. Max(50).',
			'too_short' => 'O campo "NOME" está muito curto. Min(3).'
		),
		array('email', 'maximum' => 50, 'too_long' => 'O campo "EMAIL" está muito longo. Max(50).'),
		array('login', 'maximum' => 20, 'too_long' => 'O campo "LOGIN" está muito longo. Max(20).')
	);
	
	static $validates_format_of = array(
		array(
			'email', 'with' =>'/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/',
			'message' => 'Email inválido.'
		)
	);
	
	static $validates_uniqueness_of = array(
		array('login', 'message' => 'Login já está sendo usado!'),
		array('email', 'message' => 'Email já está sendo usado!')
	);
	
	static $before_save = array('applySHA1');
	
	public function applySHA1(){
		if($_POST['Item']['password'])$this->password=sha1($_POST['Item']['password']);
	}
	
	public function getUser(){
		return strtoupper($this->read_attribute('name'));
	}
	//*/

}