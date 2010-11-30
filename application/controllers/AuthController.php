<?php
class AuthController extends AppController{
	
	// Before Actions
	protected $beforeAction_authSetup;
	protected $beforeRender_authBr;
	
	// Before Action
	protected function authSetup($r){
		$this->_includes=false;
		$this->_title='Login de acesso - Efeito FrontLine';
		$this->layout('auth/auth');
	}
	
	// Before Render
	protected function authBr($r){
		//...Code
	}
	
	public function indexAction(){
		\madeam\Session::start();
		\madeam\Session::destroy();
		array_push($this->_css,
			\madeam\helper\Html::css('/javascripts/vendor/mootools/plugins/FormCheck/theme/classic/formcheck'),
			\madeam\helper\Html::css('/stylesheets/auth')
		);
		array_push($this->_js,
			\madeam\helper\Html::js('/javascripts/vendor/mootools/plugins/FormCheck/lang/pt-BR'),
			\madeam\helper\Html::js('/javascripts/vendor/mootools/plugins/FormCheck/formcheck'),
			\madeam\helper\Html::js('/javascripts/app/auth')
		);
		$this->frm=array('_method'=>'post','_action'=>'auth');
		$this->frmRecupera=array('_method'=>'post','_action'=>'recupera');
		$this->esqueceu=\madeam\helper\Html::link('Esqueceu a senha?','#',array('id'=>'recuperaLnk','class'=>'gray _paddingLeft'));
		$this->volta=\madeam\helper\Html::link('← Voltar para o site','/',array('class'=>'white'));
	}
	
	public function authAction($r){
		$response=array('ok'=>false,'msg'=>'Erro!');
		$opts=array(
			"select"=>"id,name,email,login",
			"conditions"=>array("login=? AND password=?",$r['Item']['login'],sha1($r['Item']['password'])),
			"limit"=>1
		);
		$user=\models\User::find($opts);
		//
		if($user){
			\madeam\Session::start();
			\madeam\Session::set('logado',true);
			\madeam\Session::set('user',$user);
			//
			$goTo=\lagden\Cookie::get('referer','admin/');
			//
			$response=array('ok'=>true,'msg'=>'Login efetuado com sucesso!','path'=>\madeam\Framework::url("{$goTo}"));
		}else{
			\madeam\Session::start();
			\madeam\Session::destroy();
			$response['msg']='Usuário não cadastrado ou senha incorreta';
		}
		return \madeam\serialize\Json::encode($response);
	}
	
	public function recuperaAction($r){
		$response=array('ok'=>false,'msg'=>'Erro!');
		$option=array(
			"select"=>"id,name,email,login",
			"conditions"=>array("email=?",$r['Item']['email']),
			"limit"=>1
		);
		$user=\models\User::find($option);
		if($user){
			$send=static::send($user);
			if($send)$response=array('ok'=>true,'msg'=>'Uma nova senha foi enviada para o seu email!');
			else $response['msg']='Falha ao tentar recuperar';
		}else{
			$this->response['msg']='Email não cadastrado';
		}
		return \madeam\serialize\Json::encode($response);
	}
	
	private static function send($user){
		$result=false;
		$password=mt_rand();
		$user->password=sha1($senha);
		$update=$user->save(false);
		//
		if($update){
			$to=$user->email;
			$subject="App [Recupera]";
			$body="
			Olá <b>{$user->nome}</b>,<br/><br/>
			Segue abaixo sua nova senha de acesso ao gerenciador de conteúdo do Site:<br/><br/>
			<table>
			<tr><td>Login: </td><td>{$user->login}</td></tr>
			<tr><td>Senha: </td><td>{$password}</td></tr>
			</table>
			<br/><br/>
			Atenciosamente,<br />
			XXX";
			//
			$result=\lagden\Email::send($to,$subject,$body,false,false);
		}
		return $result;
	}

}