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
		
		$this->view = View_Bphp::create();

        $this->load = Loader_Bphp::create();


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

    /**
     * 地址重定向
     * @param $uri          control/action
     * @param null $param   get_string | array('key1'=>'val1')
     */
    public function redirect($uri, $param=null){
        $u = '/'.APP_NAME.'/'.$uri;

        //构造get参数
        $str = '';
        if(is_string($param)){
            $first = substr($param, 0, 1);
            if($first != '?'){
                $str = '?'.$param;
            }else{
                $str = $param;
            }
        }else if(is_array($param)){
            foreach($param as $key=>$val){
                $str .= $key.'='.$val.'&';
            }
            $str = '?'.rtrim($str, '&');
        }
        $u .= $str;
        header("Location: $u"); die;
    }
}