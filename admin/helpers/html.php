<?php
/**
 * 处理html标签
 * @author code29
 */
class Html_Helper{
	
	static function form($action, $method='get', $class=''){
		
		list($c, $f) = explode('.', $action);
		$url = "/index.php?" . "c=$c" . "&f=$f";
		
		echo "<form action='$url' method='$method' class='$class'> ";
	}
	static function endform(){
		echo '</form>';
	}
	
}