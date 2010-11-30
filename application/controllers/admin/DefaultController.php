<?php
namespace admin;
use \madeam\helper\Form as Form;
use \madeam\helper\Html as Html;
class DefaultController extends \CrudController{

	// Index -> Chama a listagem na primeira página
	public function indexAction($r){
		$this->reset=true;
		$this->reg=$r['id'];
		$this->listagem();
	}

	// Page -> Paginação
	public function pageAction($r){
		$this->reg=$r['id'];
		$this->listagem($r['pagina']);
	}
	
	// Busca
	public function buscaAction($r){
		$palavra=isset($r['Busca']['palavra'])?$r['Busca']['palavra']:$r['busca'];
		$this->reset=true;
		$this->busca=\lagden\Cookie::manage('palavra',stripslashes($palavra),$this->urlCode,$this->reset);
		$this->listagem();
	}

	// Complementos para newAction
	public function onNew(){
		$this->on();
	}

	// Complementos para editAction
	public function onEdit(){
		$this->on();
	}
	
	public function onList(){
		array_push($this->_js,
			Html::js('/javascripts/app/busca'),
			Html::js('/javascripts/app/lista'),
			Html::js('/javascripts/app/paginacao')
		);
		//
		// JavaScript
		$this->_javaScript="
			var path='{$this->urlCode}';
			var reg='{$this->reg}';
		";
	}
	
	// Complementos
	public function on(){
		array_push($this->_css,
			Html::css('/javascripts/vendor/mootools/plugins/FormCheck/theme/classic/formcheck')
		);
		array_push($this->_js,
			Html::js('/javascripts/vendor/mootools/plugins/FormCheck/lang/pt-BR'),
			Html::js('/javascripts/vendor/mootools/plugins/FormCheck/formcheck'),
			Html::js('/javascripts/app/formSubmit')
		);
		//
		// JavaScript
		$this->_javaScript="
			var formID='frmAdmin';
			var path='{$this->urlCode}';
			var reg='{$this->reg}';
		";
		
		$this->plus();
	}
	
	public function plus(){
		//..Code
	}

	// Listagem com paginação
	public function listagem($page=null){
		$this->cols=array('id'=>'Ação');
		$this->noSearch=Array('id');
		//
		$option['select']="id";
		$option['order']="id DESC";
		//
		$this->listAction($page,$option);
	}
}