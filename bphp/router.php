<?php
/**
 * 路由
 */

//当类初始化时，自动引入相关文件，重载了php内置的autoload函数
function __autoload($className){
	//解析文件名，得到文件的存放路径
	list($filename, $suffix) = explode('_', $className);
	
	//构造class文件路径
    if($suffix === 'Bphp'){
        $file = FRAME_ROOT . '/'. strtolower($suffix) .'/' . strtolower($filename) . '.php';
    }else{
	    $file = SERVER_ROOT . '/'. strtolower($suffix) .'s/' . strtolower($filename) . '.php';
    }

	if(file_exists($file)){
		include_once($file);
	}else{
		die("File '$file' containing calss '$className' not found.");
	}
}

try{
    $BEE = new Bee_Bphp();
    $BEE->run();
}catch (Error_Bphp $ee){
    echo $ee->echoError();
}





