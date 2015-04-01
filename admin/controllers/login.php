<?php
class Login_Controller extends Controller_Bphp{
	
	public function __construct(){
		parent::__construct();

//		if(isset($_SESSION['account'])){
//			$this->redirect('home');
//		}
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
            die('登录失败：验证码错误');
        }

		$acc = $_POST['account'];
		$pwd = $_POST['password'];

		$User = new User_Model();
		$user = $User->get_user_by_account($acc);

		if($pwd && isset($user) && $pwd == $user->password){
			
			$_SESSION['account'] = $acc;

            $this->redirect('home');
		}else{
            die('登录失败：密码错误');
		}
		
	}
	
	public function do_logout(){
		if(isset($_SESSION['account'])){
			unset($_SESSION['account']);
		}
        $this->redirect('login');
	}

}