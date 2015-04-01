<?php
/**
 * 处理html标签
 * @author code29
 */
class Html_Helper_Bphp{
	
	static function form($action, $method='get', $class=''){
		
//		list($c, $f) = explode('.', $action);
//		$url = "?" . "c=$c" . "&f=$f";
        $url = '/'.APP_NAME.'/'.$action;
		
		echo "<form action='$url' method='$method' class='$class'> ";
	}
	static function endform(){
		echo '</form>';
	}

}