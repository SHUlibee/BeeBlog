<?php
/**
 * 处理视图
 * @author code29
 */
class View_Bphp{
	
	static $VIEW_FILE = '';
	
	static $VIEW_MASTER = '';
	
	static $IS_MASTER = false;

    /**
     * 方案二
     * 加载模版文件
     * @param String $template
     * @param array $data
     * @throws Error_Bphp
     */
    static function render($template, $data = NULL){
		
		if(trim($template) == '') throw new Error_Bphp('模版文件名不能为空！');
		
		self::$VIEW_FILE	= SERVER_ROOT .'/views/'.strtolower($template).'.html.php';
		self::$VIEW_MASTER	= SERVER_ROOT .'/views/common/master.html.php';
		
		if(file_exists(self::$VIEW_FILE)){
			
			if($data){
				foreach ($data as $key=>$d){
					if(is_numeric($key)) throw new Error_Bphp('必须是 键\值 型数组');
					$$key = $d;
				}
			}
			
			if(self::$IS_MASTER){
				include(self::$VIEW_MASTER);
			}else{
				include(self::$VIEW_FILE);
			}
		}
		die;
	}
	
	/**
	 * 设置是否使用master模版
	 * @param Boolean $bool
	 */
	public function set_master($bool = true){
		self::$IS_MASTER = $bool;
	}
	
}