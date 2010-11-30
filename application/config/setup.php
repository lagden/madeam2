<?php
// title site
madeam\Framework::$title='Base site';

// set environment
madeam\Framework::$environment = (isset($_SERVER['MADEAM_ENV'])) ? $_SERVER['MADEAM_ENV'] : 'production';

switch (madeam\Framework::$environment) {
	case 'development' :
	madeam\Exception::$inlineErrors  = true;
	madeam\Exception::$debugMode     = true;
	break;
	
	case 'production' :
	madeam\Exception::$inlineErrors  = false;
	madeam\Exception::$debugMode     = false;
	break;
}

// add middleware
madeam\Framework::$middleware = array(
	'madeam\middleware\Common',
	'madeam\middleware\Sessions'
	//'madeam\middleware\Tidy'
);

// set default timezone
date_default_timezone_set('America/Sao_Paulo'); 

/**
* Vendors.
* =======================================================================
*/

// PhpThumb
//require madeam\Framework::$pathToProject . 'application/vendor/phpthumb/ThumbLib.php';

// Active Record
require madeam\Framework::$pathToProject . 'application' . DS . 'vendor' . DS . 'activerecord' . DS . 'ActiveRecord.php';
$ActiveRecord=ActiveRecord\Config::instance();
$ActiveRecord->set_connections(array(
	'development' => 'mysql://root@localhost/_base',
	'production' => 'mysql://root:123456@localhost/_base'
));
$ActiveRecord->set_default_connection(madeam\Framework::$environment);