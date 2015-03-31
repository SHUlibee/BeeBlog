<?php
class Login_Controller extends Controller_Bphp{
	
	public function __construct(){
		parent::__construct();
		
		if(isset($_SESSION['account'])){
			header("Location: index.php?c=home");
		}
	}
	
	public function index(){

        $geetest = new Geetest_Helper();
        if ($geetest->register()) {
            $data['geetest'] = $geetest->getWidget();
        }

		$this->view->render('login/view', $data);
	}
	
	public function do_login(){
        $geetest = new Geetest_Helper();
        if(!$geetest->validate()){
            header("Location: index.php?c=login"); die;
        }

		$acc = $_POST['account'];
		$pwd = $_POST['password'];

		$User = new User_Model();
		$user = $User->get_user_by_account($acc);

		if($pwd && isset($user) && $pwd == $user->password){
			
			$_SESSION['account'] = $acc;
			header("Location: index.php?c=home"); die;
		}else{
            header("Location: index.php?c=login"); die;
			//echo '<javaScript>alert("登录失败")</javaScript>';
		}
		
	}
	
	public function do_logout(){
		if(isset($_SESSION['account'])){
			unset($_SESSION['account']);
		}
	}

}