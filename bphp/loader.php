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
     * @param string $config    需要加载的配置文件
     * @param bool $assoc       返回数组or对象，默认数组
     */
    public function config($config = 'database', $assoc = false){
        echo '<pre>';

        var_dump(array(
           'db'=> array(
               'local' => array(
                   'dbdriver' => 'mysql',
                   'hostname' => 'localhost'
               )
           )
        ));

        $path = SERVER_ROOT."/config/$config.ini";

        // 检查第ini文件是否存在，如不存在，则创建之
        if(!file_exists($path)) {
            $file=fopen($path,"a");
            fwrite($file, "[$config]");
            fclose($file);
        }

        $conf = parse_ini_file($path);

        $res = array();;
        foreach($conf as $key => $value){
            $exp = explode('.', $key);

            $res +=  $this->fun($res, $exp, $value, 0, count($exp));

        }ini_get_all();
        var_dump($res);
        die;
    }

    private  function fun($arr, $key, $value, $curdeep ,$deep){
        if($curdeep >= $deep) return $value;

        $val = self::fun($arr, $key, $value, $curdeep+1, $deep);
        $arr = array(
            $key[$curdeep] => $val
        );
        return $arr;
    }

}