<?php
/**
* Madeam PHP Framework
*/

// Trace
function trace(){
	$args=func_get_args();
	$r="";
	foreach($args as $k=>$arg){
		$r.="{$k}: ".print_r($arg,true)."\n";
	}
	echo "<code><pre>{$r}</pre></code>";
}

/**
* Wrapper for htmlentities
* @param string $string
*/
function h($string){
	return htmlentities(iconv('UTF-8', 'UTF-8//IGNORE', $string), ENT_QUOTES, 'UTF-8');
}

/**
* Strip Slashes
* @param string $string
*/
function sl($string){
	return stripslashes($string);
}

// set current working directory
$cwd = dirname(dirname($_SERVER['SCRIPT_FILENAME'])); // this is prefered over getcwd() when using symlinks

// set the public directory as our current working directory
chdir($cwd);

// Define directory splitter
if(! defined('DS'))define('DS', DIRECTORY_SEPARATOR);


// if Madeam is in our local lib, include it. Otherwise use the one in the PHP include path
// note: the library in the PHP include path should only be used for Madeam development and never
// the development of a project based on madeam. Madeam should always be in the vendor directory
require './application/vendor/madeam/src/Madeam.php';

// include config files
require './application/config/setup.php';
require './application/config/routes.php';

// setup Madeam
madeam\Framework::setup(
	dirname($_SERVER['SCRIPT_FILENAME']) . '/', // example: /Users/batman/Sites/myblog/
	$_SERVER['DOCUMENT_ROOT']                   // example: /Users/batman/Sites/
);

// dispatch handles the request and returns the output  
echo madeam\Framework::dispatch(
	$_GET + $_POST + $_COOKIE,  // not always the same as $_REQUEST depending on the php.ini configuration
	$_SERVER['QUERY_STRING'],   // example: _uri=posts/view/32&blah=testing
	$_SERVER['REQUEST_METHOD']  // example: GET
);