<?php
namespace lagden;
class Pagination extends \madeam\helper\Form{

    public static function show($page=1,$pages=1,$text=null,$lang='pt-BR'){
        $adjacents=3;
        $prev=$page-1;
        $next=$page+1;
        $lastpage=$pages;
        $lpm=$pages-1;

		$anteriorLang=array('pt-BR'=>'❮','en'=>'Prior','es'=>'Anterior');
		$proximoLang=array('pt-BR'=>'❯','en'=>'Next','es'=>'Pr&#243;ximo');
		$paginaLang=array('pt-BR'=>'P&#225;gina','en'=>'Page','es'=>'P&#225;gina');
       
        $anterior='<button type="button" pagina="'.$prev.'" class="prior paginacao paginacaoUI">'.$anteriorLang[$lang].'</button>';
        $anteriorD='<button type="button" class="priorD paginacaoDisabled paginacaoUI">'.$anteriorLang[$lang].'</button>';
        $proximo='<button type="button" pagina="'.$next.'" class="next paginacao paginacaoUI">'.$proximoLang[$lang].'</button>';
        $proximoD='<button type="button" class="nextD paginacaoDisabled paginacaoUI">'.$proximoLang[$lang].'</button>';
       
        $pagination='<div class="pagination">';
        if($text)$pagination.="<span>{$text}</span>";
        else $pagination.="<span>{$paginaLang[$lang]} {$page}/{$pages}</span>";
       
        if($lastpage > 1){
			
			$pagination.=" ";
			
			//previous button
			if ($page > 1)$pagination.= $anterior;
			else $pagination.= $anteriorD;	//disabled
			
			//pages	
			if($lastpage < 7 + ($adjacents * 2)){	
				for($counter = 1; $counter <= $lastpage; $counter++)$pagination.=self::countPage($counter,$page);
			}elseif($lastpage > 5 + ($adjacents * 2)){
				if($page < 1 + ($adjacents * 2)){
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)$pagination.=self::countPage($counter,$page);
					$pagination.=self::lastPage($lpm,$lastpage);
				}elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
					$pagination.=self::oneTwo();
					for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)$pagination.=self::countPage($counter,$page);
					$pagination.=self::lastPage($lpm,$lastpage);
				}else{
					$pagination.=self::oneTwo();
					for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)$pagination.=self::countPage($counter,$page);
				}
			}
			
			//next button
			if ($page < $counter - 1)$pagination.=$proximo;
			else $pagination.=$proximoD;
		}
		
		$pagination.='</div>';
		
		return $pagination;
	}
	
	protected static function countPage($counter,$page){
		if($counter == $page)return '<button type="button" class="paginacaoSelecionado paginacaoUI">'.$counter.'</button>';
		else return '<button type="button" pagina="'.$counter.'" class="paginacao paginacaoUI">'.$counter.'</button>';
	}
	
	protected static function lastPage($lpm,$lastpage){
		return '
		<button type="button" class="paginacaoUI">...</button>
		<button type="button" pagina="'.$lpm.'" class="paginacao paginacaoUI">'.$lpm.'</button>
		<button type="button" pagina="'.$lastpage.'" class="paginacao paginacaoUI">'.$lastpage.'</button>
		';
	}
	
	protected static function oneTwo(){
		return '
		<button type="button" pagina="1" class="paginacao paginacaoUI">1</button>
		<button type="button" pagina="2" class="paginacao paginacaoUI">2</button>
		<button type="button" class="paginacaoUI">...</button>
		';
	}
	
}