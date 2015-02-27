<?php
class Home_Controller extends Base_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->view->set_master();
	}
	
	public function index(){
		$this->view->render('home/view');
	}


    public function test(){
        $this->load->helper('structure');
    }
	
}