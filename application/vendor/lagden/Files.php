<?php
/*
* Require Image Class 
*
*/
namespace lagden;
class Files{
	
	static public function imagesSave($targetDir,$files,$id=false,$dimension=array(1300,1300),$maxsize=2097152){
		$fail=false;
		$msg=array();
		if(isset($_FILES['Files'])){
			
			$new=array();
			foreach((array)$_FILES['Files'] as $k=>$v){
				foreach((array)$v as $a=>$b){
					$new[$a][$k]=$b;
				}
			}
			//
			if($id)$itemDir=$targetDir. $id .DS;
			else $itemDir=$targetDir;
			if(!is_dir($itemDir))mkdir($itemDir,0777,true);
			//
			foreach((array)$new as $v){
				if($v['error']===0){
					if($v['size']>=$maxsize){
						$fail=true;
						$msg[]="{$v['name']}: maior que o permitido";
					}elseif(preg_match('/^image\/(jpg|jpeg|png|gif)$/',$v['type'],$matches)){
						$fileDimension=getimagesize($v['tmp_name']);
						if($fileDimension){
							if($fileDimension['0']<=$dimension[0]&&$fileDimension['1']<=$dimension[1]){
								//
								//
								$img=\phpthumb\PhpThumbFactory::create($v['tmp_name']);
								foreach((array)$files as $params){
									if(isset($params['func'])){
										foreach((array)$params['func'] as $func=>$par){
											if($func=='adaptiveResize')$img->adaptiveResize($par[0],$par[1]);
											if($func=='cropFromCenter')$img->cropFromCenter($par[0]);
											if($func=='resizePercent')$img->resizePercent($par[0]);
										}
									}
									$img->save($itemDir.$params['file'].".{$params['ext']}",$params['ext']);
								}
								//
								//
							}else{
								$fail=true;
								$msg[]="{$v['name']}: dimensão maior que o permitido";
							}
						}else{
							$fail=true;
							$msg[]="{$v['name']}: não foi possível calcular a dimensão";
						}
					}else{
						$fail=true;
						$msg[]="{$v['name']}: tipo inválido";
					}
					unlink($v['tmp_name']);
					if($fail){
						return $msg;
					}
				}
			}
			return true;
		}else return false;
	}
	
	
	static public function filesRemove($targetDir,$id=null,$name=false){
		if($id){
			$itemDir=$targetDir. $id .DS;
			if(is_dir($itemDir)){
				if($handle=opendir($itemDir)){
				    while(false!==($file=readdir($handle))){
						if(file_exists($itemDir.$file)){
							if($file!="."&&$file!=".."){
								if($name){
									if(file_exists($itemDir.$name)){
										unlink($itemDir.$name);
										return true;
									}
								}else unlink($itemDir.$file);
							}
						}
				    }
				    closedir($handle);
				}
				rmdir($itemDir);
			}
		}else{
			$itemDir=$targetDir;
			if($name){
				if(file_exists($itemDir.$name))unlink($itemDir.$name);
			}
		}
	}
	
}