<?php
use \madeam\serialize\Sphp as Sphp;
use \madeam\Framework as F;
use \madeam\helper\Html as Html;
use \ActiveRecord\SQLBuilder as ARS;
use \Imagine\Image as II;
use \Imagine\Processor as IP;
use \simpleFlickr\Api as Flickr;
use \simpleFlickr\methods as methods;
//class IndexController extends AppController{
class IndexController extends AppController{
	
	protected $beforeAction_indexSetup;
	
	public function indexSetup(){
		$this->_title="Index - $this->_title";
	}
	
	public function indexAction($r){
		$this->user=\models\User::first();
		//trace("Username: {$user->name}","--------------");
		//trace(\models\User::connection()->last_query,'');
		//foreach((array)$user->orders as $v)trace("Order ID: {$v->id}","Total: {$v->total}","--------------");
		//trace(\models\User::connection()->last_query,'');
		//
		$order=\models\Order::first();
		//if($order->user)trace("Order Username: {$order->user->name}","Total: {$order->total}","--------------");
		//trace(\models\User::connection()->last_query,'');
		//
		// $user=User::first();
		// trace("Username: {$user->name}","--------------");
		// trace(User::connection()->last_query,'');
		// foreach((array)$user->orders as $v)trace("Order ID: {$v->id}","Total: {$v->total}","--------------");
		// trace(User::connection()->last_query,'');
		// //
		// $order=Order::first();
		// if($order->user)trace("Order Username: {$order->user->name}","Total: {$order->total}","--------------");
		// trace(User::connection()->last_query,'');
		//return false;
		
		$this->_javaScript="
			jQuery.get(_baseUrl+'index/ajax/',function(data){dbug(data);});
		";
		
	}
	
	public function ajaxAction($r){
		echo "Ulalalaaaaa";
		return false;
	}
	
	// Teste do Plugin Imagine
	public function imagineAction(){
		$dir=F::$pathToProject . 'public' . DS . 'images' . DS;	
		//
		$image=new II("{$dir}sa.jpg");
		$processor=new IP();
		$processor
		    ->resize(200,200,4)
		    ->crop(0, 0, 100, 100)
			->save("{$dir}sa2.png",null,array('quality'=>100))
			->process($image);
		//
		return false;
	}
	
	public function flickrAction(){
		$dirFlickr=F::$pathToProject . 'public' . DS . 'files' . DS . 'flickr' . DS;
		$dir=F::$pathToProject . 'application' . DS . 'api' . DS . 'flickr' . DS;
		//
		$flickr=Flickr::createFrom($dir.'config.json');
		$flickr->_userId='35972250@N06';
		//
		$photo=new methods\Photo($flickr);
		$photoSets=new methods\Photosets($flickr);
		//
		$list=$photoSets->getList(array('user_id'=>$flickr->_userId,'format'=>'php_serial'));
		$r=$list->execute();
		//
		$img=array();
		//
		foreach($r->response['photosets']['photoset'] as $v){
			$url=$photo->img($v,'m',true);
			$info = pathinfo($url);
			$file=md5($url).".{$info['extension']}";
			if(!file_exists($dirFlickr.$file)){
				$photo->save($dirFlickr,$file);
				trace('salvo',$dirFlickr,$file);
			}else trace('cacheado',$dirFlickr,$file);
			$img[]=Html::img("/files/flickr/{$file}");
		}
		trace($img);
		return false;
	}
}