<?php
class ListagemController extends madeam\Controller{
	
	public function indexAction(){
		//...Code
	}
	
	public function tabelaAction($r){
		$this->layout('empty/empty');
		$this->result=$r['_modelo'];
		$this->cols=$r['_cols'];
	}

}