<?php
class Login_Controller extends Controller_Lib{
	
	public function __construct(){
		parent::__construct();
		
		if(isset($_SESSION['account'])){
			header("Location: index.php?c=home");
		}
	}
	
	public function index(){

		$this->view->render('login/view');
	}
	
	public function do_login(){
		$acc = $_POST['account'];
		$pwd = $_POST['password'];
		
		$User = new User_Model();
		$user = $User->get_user_by_account($acc);

		if($pwd && isset($user) && $pwd == $user->password){
			
			$_SESSION['account'] = $acc;
			var_dump('you password is matched!!');
			header("Location: index.php?c=home");
		}else{
            header("Location: index.php?c=user");
			//echo '<javaScript>alert("登录失败")</javaScript>';
		}
		
	}
	
	public function do_logout(){
		if(isset($_SESSION['account'])){
			unset($_SESSION['account']);
		}
	}

}