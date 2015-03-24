<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-3-24
 * Time: 上午10:22
 */

abstract class Db_Bphp{


    // 查询表达式
    protected $selectSql  = 'SELECT%DISTINCT% %FIELD% FROM %TABLE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT% %UNION%%COMMENT%';
    protected $insertSql = '';
    protected $updateSql = '';
    protected $deleteSql = '';

    public static function factory($dbType){
        $class = ucfirst($dbType).'_Driver_Bphp';
        $db = new $class();
        return $db;
    }

    /**
     * 表名分析 支持多表
     */
    protected function parseTable($tables){
        if(is_array($tables)) {// 支持别名定义
            $array   =  array();
            foreach ($tables as $table=>$alias){
                if(!is_numeric($table))
                    $array[] =  $this->parseKey($table).' '.$this->parseKey($alias);
                else
                    $array[] =  $this->parseKey($table);
            }
            $tables  =  $array;
        }elseif(is_string($tables)){
            $tables  =  explode(',',$tables);
            array_walk($tables, array(&$this, 'parseKey'));
        }
        $tables = implode(',',$tables);
        return $tables;
    }
    protected function parseDistinct($key) {
        return $key;
    }

    /**
     * 字段分析
     */
    protected function parseField($fields) {
        if(is_string($fields) && strpos($fields,',')) {
            $fields    = explode(',',$fields);
        }
        if(is_array($fields)) {
            // 完善数组方式传字段名的支持
            // 支持 'field1'=>'field2' 这样的字段别名定义
            $array   =  array();
            foreach ($fields as $key=>$field){
                if(!is_numeric($key))
                    $array[] =  $this->parseKey($key).' AS '.$this->parseKey($field);
                else
                    $array[] =  $this->parseKey($field);
            }
            $fieldsStr = implode(',', $array);
        }elseif(is_string($fields) && !empty($fields)) {
            $fieldsStr = $this->parseKey($fields);
        }else{
            $fieldsStr = '*';
        }
        //TODO 如果是查询全部字段，并且是join的方式，那么就把要查的表加个别名，以免字段被覆盖
        return $fieldsStr;
    }
    protected function parseJoin($key) {
        return $key;
    }

    /**
     * where分析 目前只支持字符串条件 和 array('field <>' => $data1)
     */
    protected function parseWhere($where) {
        $whereStr = '';
        if(is_string($where)){
            // 直接使用字符串条件
            $whereStr = $where;
        }elseif(is_array($where)){ // 使用数组表达式
            $operate  = isset($where['_logic'])?strtoupper($where['_logic']):'';
            if(in_array($operate,array('AND','OR','XOR'))){
                // 定义逻辑运算规则 例如 OR XOR AND NOT
                $operate    =   ' '.$operate.' ';
                unset($where['_logic']);
            }else{
                // 默认进行 AND 运算
                $operate    =   ' AND ';
            }
            foreach ($where as $key=>$val){
                $whereStr .= $key;
                if(is_numeric($val)){
                    $whereStr .= $val;
                }else{
                    $whereStr .= "'".$val."'";
                }
                $whereStr .= $operate;
            }
            $whereStr = substr($whereStr,0,-strlen($operate));
        }

        return empty($whereStr)?'':' WHERE '.$whereStr;
    }
    protected function parseGroup($key) {
        return $key;
    }
    protected function parseHaving($key) {
        return $key;
    }
    protected function parseOrder($key) {
        return $key;
    }

    /**
     * limit分析
     */
    protected function parseLimit($limit) {
        return !empty($limit)?   ' LIMIT '.$limit.' ':'';
    }
    protected function parseUnion($key) {
        return $key;
    }
    /**
     * 字段名分析
     */
    protected function parseKey(&$key) {
        return $key;
    }
    /**
     * 生成查询SQL
     */
    public function buildSelectSql($options = array()){
        $sql = $this->parseSql($this->selectSql, $options);

        return $sql;
    }

    /**
     * 替换SQL语句中表达式
     */
    public function parseSql($sql,$options=array()){
        $sql   = str_replace(
            array('%TABLE%','%DISTINCT%','%FIELD%','%JOIN%','%WHERE%','%GROUP%','%HAVING%','%ORDER%','%LIMIT%','%UNION%','%COMMENT%'),
            array(
                $this->parseTable($options['table']),
                $this->parseDistinct(isset($options['distinct'])?$options['distinct']:false),
                $this->parseField(!empty($options['field'])?$options['field']:'*'),
                $this->parseJoin(!empty($options['join'])?$options['join']:''),
                $this->parseWhere(!empty($options['where'])?$options['where']:''),
                $this->parseGroup(!empty($options['group'])?$options['group']:''),
                $this->parseHaving(!empty($options['having'])?$options['having']:''),
                $this->parseOrder(!empty($options['order'])?$options['order']:''),
                $this->parseLimit(!empty($options['limit'])?$options['limit']:''),
                $this->parseUnion(!empty($options['union'])?$options['union']:''),
            ),$sql);
        return $sql;
    }

    /**
     * 数据库连接
     */
    abstract public function connect($link);
}