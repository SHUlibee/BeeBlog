<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-3-24
 * Time: 上午10:22
 */

class Mysql_Driver_Bphp extends Db_Bphp{

    /**
     * mysql数据库连接
     * @param $link
     * @return mixed|resource
     * @throws Error_Bphp
     */
    public function connect($link){

        $con = mysql_connect(
            $link['hostname'],
            $link['username'],
            $link['password']
        );

        if(!$con) throw new Error_Bphp("Could not connect :".mysql_error());
        if(!mysql_select_db($link['database'], $con))
            throw new Error_Bphp('Could not connect DB you had set :'.mysql_error());

        return $con;
    }

    /**
     * 执行查询 返回数据集
     * @param $options
     * @return array
     */
    public function query($options){

        if(is_string($options)){
            $query = $options;
        }else{
            $query = $this->buildSelectSql($options);
        }

        $res = mysql_query($query);
        $result = array();
        while ($row = mysql_fetch_object($res)){
            $result[] = $row;
        }
        return $result;
    }

    public function execute($query){

        return mysql_query($query);
    }

    /**
     * 字段和表名处理添加`
     * @param $key
     * @return string
     */
    protected function parseKey($key){
        $key   =  trim($key);
        if(!is_numeric($key) && !preg_match('/[,\'\"\*\(\)`.\s]/',$key)) {
            $key = '`'.$key.'`';
        }
        return $key;
    }
}