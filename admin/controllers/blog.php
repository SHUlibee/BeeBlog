<?php
class Blog_Controller extends Base_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->view->set_master();
	}
	
	public function index(){
		$this->view->render('blog/view');
	}

    public function add(){
        $this->view->render('blog/add');
    }


}