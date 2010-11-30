<?php
class IncludesController extends madeam\Controller{
	
	public function indexAction(){
		//...Code
	}
	
	public function headerAction(){
		$this->layout('empty/empty');
	}
	
	public function navAction($r){
		$this->layout('empty/empty');
		$this->menu=static::dropdown($r['_menu']);
	}
	
	public function footerAction($r){
		$this->layout('empty/empty');
	}
	
	private static function dropdown($menu){ 
		$drop="<ul>";
		foreach($menu as $k=>$v){
			$k=h(sl($k));
			if(isset($v['sub'])){
				$drop.='<li'.((isset($v['class']))?' class="'.$v['class'].'"':'').'>'.\madeam\helper\Html::a($k,$v['link']);
				if(count($v['sub'])>0){
					$drop.='<ul>';
					foreach($v['sub'] as $a=>$b){
						$a=h(sl($a));
						$drop.='<li>'.\madeam\helper\Html::a($a,$b).'</li>';
					}
					$drop.='</ul>';
				}
				$drop.='</li>';			
			}else $drop.='<li'.((isset($v['class']))?' class="'.$v['class'].'"':'').'>'.\madeam\helper\Html::a($k,$v['link']);
		}
		$drop.="</ul>"."\n";
		return $drop;
	}

}