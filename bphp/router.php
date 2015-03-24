<?php
/**
 * 路由
 */

//当类初始化时，自动引入相关文件，重载了php内置的autoload函数
function __autoload($className){

    //解析文件名，得到文件的存放路径
    $classExp = explode('_', $className);
    $len = count($classExp);

    //构造class文件路径
    if($classExp[$len-1] === 'Bphp'){
        $file = dirname(FRAME_ROOT) ;
    }else{
        $file = SERVER_ROOT;
        $classExp[$len-1] .= 's';
    }
    for($i = $len-1; $i >= 0; $i--){
        $file .= '/' . strtolower($classExp[$i]);
    }
    $file .= '.php';

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





