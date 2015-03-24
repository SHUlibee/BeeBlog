<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-3-24
 * Time: 上午10:22
 */

abstract class Db_Bphp{

    public static function factory($dbType){
        $class = ucfirst($dbType).'_Bphp';
        $db = new $class();
        return $db;
    }

    /**
     * 数据库连接
     * @param $link
     * @return mixed
     */
    abstract public function connect($link);
}