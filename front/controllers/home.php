<?php
class Home_Controller extends Controller_Bphp{
	
	public function __construct(){
		parent::__construct();
		
	}
	
	public function index(){
		$this->view->render('home/index');
	}


}