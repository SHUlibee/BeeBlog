<?php
/**
 * 处理控制器
 * @author code29
 */
class Controller_Bphp{

    /**
     * @var null|View_Bphp 视图
     */
    public $view = null;

    /**
     * @var null|Loader_Bphp 装载器
     */
    public $load = null;

    /**
     * @var null|请求类
     */
    public $request = null;

	public function __construct(){
		
		$this->view = new View_Bphp();
        $this->load = new Loader_Bphp();
	}

    /**
     * 设置请求类
     * @param $ctrl
     * @param $func
     * @param $vars
     */
    public function setRequest($ctrl, $func, $vars){
        $req = new stdClass();

        $req->ctrl      = $ctrl;
        $req->func      = $func;
        $req->params['get']     = $this->_inputFilter($vars);
        $req->params['post']    = $this->_inputFilter($_POST);

        $this->request = $req;
    }

    /**
     * 递归过滤
     * @param $arr
     * @return mixed
     */
    private function _inputFilter($arr){

        while(list($key,$var) = each($arr)) {
            if ($key != 'argc' && $key != 'argv' && (strtoupper($key) != $key || ''.intval($key) == "$key")) {
                if (is_string($var)) {
                    $arr[$key] = stripslashes($var);
                }
                if (is_array($var))  {
                    $arr[$key] = $this->_inputFilter($var);
                }
            }
        }
        return $arr;
    }

}