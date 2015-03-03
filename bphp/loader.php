<?php
/**
 * 装载器 -- 使用静态变量存储实例，保证每个装载的类的单例性
 * @author bee
 */
class Loader_Bphp{

    private static $load;

	public function __construct(){
		
	}

    /**
     * 单例设计模式，保证model只被实例化一次
     * @param $model
     * @return Xxx_Model
     */
    public function model($model){

        $model = $model.'_Model';
        if(!isset(self::$load[$model])){
            self::$load[$model] = new $model();
        }
        return self::$load[$model];
    }

    /**
     * 装载工具类
     * @param $helper 帮助类文件名
     * @return mixed
     */
    public function helper($helper){
        $helper = $helper.'_Helper';
        if(!isset(self::$load[$helper])){
            self::$load[$helper] = new $helper();
        }
        return self::$load[$helper];
    }

    /**
     * 装载后缀名为ini的配置文件
     * @param string $section    需要加载的配置段
     * @param string $env       配置文件名称
     * @return array
     * @throws Error_Bphp
     */
    public static function config($section = '', $env = ENVIRONMENT){
        $config = $section.$env.'_Config';
        if(!isset(self::$load[$config])){
            $path = SERVER_ROOT."/config/$env.ini";

            // 检查第ini文件是否存在，如不存在，则创建之
            if(!file_exists($path)) {
                throw new Error_Bphp("The file: $path . is not exists");
            }
            $conf = parse_ini_file($path, true);

            if(empty($section)){
                self::$load[$config] = $conf;
            }else{
                if(!isset($conf[$section])){
                    throw new Error_Bphp("There is not $section section in $path");
                }
                self::$load[$config] = $conf[$section];
            }
        }
        return self::$load[$config];
    }


}