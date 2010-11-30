<?php
class CrudController extends AppController{
	
	// Ação
	public $acaoNew="Novo registro";
	public $acaoEdit="Editando registro";
	public $acaoLista="Listagem";
	
	// Listagem Views
	public $add='Adicionar um novo';
	public $tfoot=null;
	public $paginacao=null;
	public $cols=array('id'=>'Ação');
	
	// Listagem Controller
	public $reset=false;
	public $limit=50;
	public $page=1;
	
	// Path and Model
	public $url='/';
	public $formUrl='/';
	public $modelo=null;
	public $noSearch=array();
	
	// Novo Item
	public function newAction($r){
		if($r['erros'])$this->erros=$r['erros'];
		$this->view("{$this->formUrl}/form");
		$this->onNew();
		$this->acao=$this->acaoNew;
		//
		$this->frm=array('_method'=>'post','_action'=>'create');
		$this->item=null;
		$this->_uri="{$this->url}/new/";
	}
	
	// Edit Item
	public function editAction($r){
		if($r['erros'])$this->erros=$r['erros'];
		$modelo=$this->modelo;
		$this->acao=$this->acaoEdit;
		//
		$this->frm=array('_method'=>'put','_action'=>'update');
		$this->_uri="{$this->url}/edit/{$r['id']}";
		//
		try{
			$this->item=$modelo::find($r['id']);
			$this->reg=$r['id'];
			$this->view("{$this->formUrl}/form");
			$this->onEdit();
		}catch(Exception $e){
			$this->view('default/erro');
			$this->erro="{$e}: Não foi possível encontrar o registro nº {$r['id']}.";
		}
	}
	
	// Create
	public function createAction($r){
		$run=self::run($r);
		if($r['_ajax']==1)return $run;
	}
	
	// Update
	public function updateAction($r){
		$run=self::run($r);
		if($r['_ajax']==1)return $run;
	}
	
	// Create or Update
	private function run($r){
		$this->response=array('ok'=>false,'erros'=>false,'msg'=>'Erro!');
		$m=false;
		$modelo=$this->modelo;
		//
		if($r['_method']=='post')$m=new $modelo();
		//			
		if($r['_method']=='put'){
			try{
				$m=$modelo::find($r['Item']['id']);
			}catch(Exception $e){
				if($r['_ajax']==1){
					$this->response['msg']="Não foi possível encontrar o registro nº {$r['Item']['id']}.";
					return \madeam\serialize\Json::encode($this->response);
				}else{
					$this->view('default/erro');
					$this->erro="Não foi possível encontrar o registro nº {$r['Item']['id']}.";
				}
			}
		}
		//
		if($m){
			// Set
			// Migrado para o método before_save do modelo os itens que precisam ser null
			//$fields=array('created_at','senha');
			foreach($m->attributes() as $k=>$v){
				if($k!='id'){
					if(isset($r['Item'][$k]))$m->$k=$r['Item'][$k];
					//elseif(!in_array($k,$fields))$m->$k=null;
				}
			}
			//
			//Grava
			$m->save();
			//
			//Erro
			if($m->errors->size()){
				$prep=array();
				foreach($r['Item'] as $k=>$v){
					$campo=$m->errors->on($k);
					if($campo!=null)$prep[]=$campo;
				}
				// Preparando
				foreach($prep as $er){
					if(is_array($er)){
						foreach($er as $msg)$this->erros[]=$msg;
					}else $this->erros[]=$er; 
				}
				//
				if($r['_ajax']==1){
					$this->response['ok']=true;
					$this->response['erros']=true;
					$this->response['msg']=$this->erros;
					return \madeam\serialize\Json::encode($this->response);
				}else{
					if($r['_method']=='put')$this->editAction($r);
					else $this->newAction();
				}
			//	
			// Ok
			}else{
				if($r['_ajax']==1){
					$this->response['ok']=true;
					$this->response['msg']='Registro salvo!';
					$this->response['id']=$m->id;
					return \madeam\serialize\Json::encode($this->response);
				}else{
					if($r['_method']=='put'){
						$page=\lagden\Cookie::manage('page',1,$this->urlCode);
						\madeam\Framework::redirect("{$this->url}/page/{$page}/{$r['Item']['id']}");	
					}else \madeam\Framework::redirect("{$this->url}/index/{$m->id}");
				}
			}
		// Erro no Modelo
		}else{
			if($r['_ajax']==1){
				$this->response['ok']=false;
				$this->response['msg']='Não foi possível salvar o registro.';
				return \madeam\serialize\Json::encode($this->response);
			}else{
				$this->view('default/erro');
				$this->erro="Não foi possível salvar o registro.";
			}
		}
	}
	
	// Remove
	public function deleteAction($r){
		$this->view('default/erro');
		$this->response=array('ok'=>false,'msg'=>'Erro!');
		$modelo=$this->modelo;
		try{
			$m=$modelo::find($r['id']);
			$success=$m->delete();
			if($r['_ajax']==1){
				if($success)$this->response=array('ok'=>true,'msg'=>'Registro removido!');
				else $this->response=array('ok'=>false,'msg'=>"Não foi possível remover o registro nº {$r['id']}.");
				return \madeam\serialize\Json::encode($this->response);
			}else{
				if($success){
					$page=\lagden\Cookie::manage('page',1,$this->urlCode);
					\madeam\Framework::redirect("{$this->url}/page/{$page}");
				}else $this->erro="Não foi possível remover o registro nº {$r['id']}.";
			}
		}catch(Exception $e){
			if($r['_ajax']==1){
				$this->response['msg']="Não foi possível encontrar o registro nº {$r['id']}.";
				return \madeam\serialize\Json::encode($this->response);
			}else{
				$this->erro="Não foi possível encontrar o registro nº {$r['id']}.";
			}
		}
	}
	
	// Listagem
	public function listAction($page=null,$option=array(),$select=false,$view='listagem/listagem'){
		$this->view($view);
		$modelo=$this->modelo;
		$this->acao=$this->acaoLista;
		
		// Table and Columns
		$tabela=$modelo::table()->table;
		$colunas=array_keys($modelo::table()->columns);
		
		// Verifica os cookies
		$this->page=\lagden\Cookie::manage('page',(($page)?$page:1),$this->urlCode,true);
		$this->busca=($this->busca)?$this->busca:\lagden\Cookie::manage('palavra',null,$this->urlCode,$this->reset);
		
		// Busca
		if($this->busca){
			// UTF-8
			$this->busca=utf8_encode($this->busca);
			//
			// No search
			foreach((array)$this->noSearch as $v){
				$k=array_search($v,$colunas);
				if($k!==false)unset($colunas[$k]);
			}
			//
			$likes=array();
			foreach($colunas as $v)$likes[]="{$tabela}.{$v} like '%{$this->busca}%'";
			$optLike=join(' OR ',$likes);
			//
			if(isset($option['conditions']))$option['conditions']="({$optLike}) AND {$option['conditions']}";
			else $option['conditions']=$optLike;
		}
		//
		
		// Total
		$optCount['conditions']=isset($option['conditions'])?$option['conditions']:array();
		$optCount['joins']=isset($option['joins'])?$option['joins']:array();
		$total=$modelo::count($optCount);
		
		// Pages
		$pages=ceil($total/$this->limit);
		$pages=($pages>0)?$pages:1;
		if($this->page>$pages){
			$this->page=\lagden\Cookie::manage('page',$pages,$this->urlCode,true);
		}
		
		// Options
		$option["select"]=isset($option['select'])?$option['select']:join(',',array_keys($this->cols));
		$option["limit"]=$this->limit;
		$option["offset"]=($this->page-1)*$this->limit;
		
		// Resultado
		$this->result=$modelo::all($option);		
		
		// Paginação
		$this->paginacao=\lagden\Pagination::show($this->page,$pages);
		
		// Complemento
		$this->onList();
	}
	
	// Complementos
	public function onNew(){
		// ...Code
	}
	
	public function onEdit(){
		// ...Code
	}
	
	public function onList(){
		// ...Code
	}
			
}