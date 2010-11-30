<?php
define("_TITLE", madeam\Framework::$title);

class AppController extends madeam\Controller{
	
	// Meta
	public $_keywords='base,default';
	public $_description='Base';
	
	// Title
	public $_title=_TITLE;
	
	// Css
	public $_css=array();
	
	// Js
	public $_js=array();
	
	// JavaScript
	public $_javaScriptApp=null;
	public $_javaScript=null;
	
	// Header, Nav and Footer
	public $_header=null;
	public $_nav=null;
	public $_footer=null;
	
	// Admin
	public $_admin=false;
	
	// Includes
	public $_includes=true;
	
	// Before Actions
	protected $beforeAction_appSetup;
	protected $beforeRender_appBr;
	
	// Before Action
	protected function appSetup($r){
		// Admin
		if(preg_match("/admin/i",$r['_uri']))$this->_admin=true;
		//
		// Auth
		if($this->_admin){
			\lagden\Cookie::set('referer',$r['_uri']);
			$logged=static::verifyLogin($r);
			if(!$logged)\madeam\Framework::redirect("auth/");
		}
		//
		// JS
		self::pushJs(
			'/javascripts/app/debug',
			'/javascripts/vendor/mootools/mootools-core-1.3',
			'/javascripts/vendor/mootools/mootools-more',
			'/javascripts/vendor/jquery/jquery-1.4.4'
		);	
		//
		// CSS
		self::pushCss(
			'/stylesheets/reset',
			'/stylesheets/geral'
		);
		//
		if($this->_admin){
			// CSS Admin
			self::pushCss(
				'/stylesheets/admin/admin',
				'/stylesheets/admin/menu'
			);
		}else{
			// CSS Site
			self::pushCss(
				'/stylesheets/site/site'
			);
		}
		//
		// JavaScript
		$baseUrl=\madeam\Framework::url('/');
		$baseImages=\madeam\Framework::url('/images/');
		$baseCss=\madeam\Framework::url('/stylesheets/');
		$baseJs=\madeam\Framework::url('/javascripts/');
		$this->_javaScriptApp="
			jQuery.noConflict();
			var _baseUrl='{$baseUrl}';
			var _baseImages='{$baseImages}';
			var _baseCss='{$baseCss}';
			var _baseJs='{$baseJs}';
			var _uri=new URI();
			dbug(_uri);
			dbug(_uri.get('host'),_uri.get('directory'));
		";
	}
	//
	// Before Render
	protected function appBr($r){
		if($this->_includes){
			if($this->_admin){
				$_menu=static::menuAdmin();
				$this->layout('admin/admin');
				$this->_nav=\madeam\Framework::control(array('_controller' => 'includes', '_action' => 'nav', '_menu' => $_menu));
			}else{
				$_menu=self::menu();
				$this->_header=\madeam\Framework::control(array('_controller' => 'includes', '_action' => 'header'));
				$this->_nav=\madeam\Framework::control(array('_controller' => 'includes', '_action' => 'nav', '_menu' => $_menu));
				$this->_footer=\madeam\Framework::control(array('_controller' => 'includes', '_action' => 'footer'));
			}
		}
	}
	//
	// Menu Admin
	static private function menuAdmin(){
		$menu['Home']['link']='admin/index';
		$menu['Site']['link']='#';
		$menu['Site']['sub']=array(
			'Seções'=>"admin/secoes/",
			'Conteúdos'=>"admin/contents/",
		);
		$menu['Usuários']['link']='admin/users/';
		$menu['Logout']['link']='auth/';
		return $menu;
	}
	//
	// Menu Site
	private function menu(){
		/*
		$cachePath=\madeam\Framework::$pathToProject . 'public' . DS . 'cache' . DS . 'menu' . DS;
		$cache=\lagden\Cache::get($cachePath,"menu.txt");
		//$cache=false;
		//
		if($cache){
			$menu=\madeam\serialize\Sphp::decode($cache);
		}else{
			$secoes=\models\Section::all(array('conditions'=>array('ativo = ?',1)));
			//
			foreach((array)$secoes as $secao){
				$menu[$secao->secao]['linkOriginal']='site/'.$secao->slug;
				//$menu[$secao->secao]['link']=$menu[$secao->secao]['linkOriginal'];//'#';
				$menu[$secao->secao]['link']='#';
				//$contents=\models\Content::all(array('conditions'=>array('ativo = ? AND secao_id = ?',1,$secao->id)));
				$contents=$secao->simplecontents;
				foreach((array)$contents as $content){
					$menu[$secao->secao]['sub'][$content->titulo]="{$menu[$secao->secao]['linkOriginal']}/{$content->slug}/";
				}
			}
			//
			//trace($menu);
			//
			//
			$menu['Utilidades']['sub']['Guia de Raças']='guia-de-racas/';
			$menu['Utilidades']['sub']['Meu Primeiro Pet']='index/manual/';
			//
			// Videos
			$menu['Alexandre Rossi']['sub']['Vídeos']='videos/';
			$menu['Alexandre Rossi']['sub']['Seu pet te faz bem']='materias/';
			//
			// Agenda
			//if(isset($menu['Agenda']))$menu['Agenda']['sub']['Minha Agenda']='agenda/';
			$menu['Agenda']['link']='agenda/';
			//
			$cache=\lagden\Cache::set($cachePath,"menu.txt",\madeam\serialize\Sphp::encode($menu));
		}
		//
		return $menu;
		//*/
		return array();
	}
	//
	// Verifica se está logado
	static public function verifyLogin(){
		$logado=\madeam\Session::get('logado');
		return $logado;
	}
	
	protected function pushCss(){
		$args=func_get_args();
		foreach($args as $arg){
			array_push($this->_css,\madeam\helper\Html::css($arg));
		}
	}
	
	protected function pushJs(){
		$args=func_get_args();
		foreach($args as $arg){
			array_push($this->_js,\madeam\helper\Html::js($arg));
		}
	}
	
}
