<?php
/**
 * 处理模型
 * @author bee
 */
class Model_Bphp{

	/**
	 * 数据库名称
	 */
	protected $db_name = 'default';

    /**
     * 数据库实例
     */
    protected $db = null;

    /**
     * sql选项
     */
    protected $options = null;

	/**
	 * 数据库连接参数
	 */
	protected $link = NULL;

	/**
	 * 数据库连接
	 */
	protected $con = NULL;

	/**
	 * sql语句
	 */
	protected $query = '';

	public function __construct(){

		$this->link = Loader_Bphp::config('database', ENVIRONMENT);
        $this->db = Db_Bphp::factory($this->link['dbdriver']);
        $this->prefix = $this->link['prefix'];
		if(isset($this->link)){
//			$this->connect_db();
            $this->db->connect($this->link);
		}else{
			throw new Error_Bphp("This database does not exist!");
		}
	}

	/**
	 * select 查询
	 * @param string $query 当参数为空或者不传时，采用构造查询的形式
	 * @return object select查询结果
	 */
	protected function get($query = ''){

		if($query) $this->query = $query;

		$res = mysql_query($this->query);
		$result = array();
		while ($row = mysql_fetch_object($res)){
			$result[] = $row;
		}
		return $result;
	}


    public function find(){
        $this->options['limit'] = 1;
        $res = $this->db->query($this->options);
        return $res;
    }
    public function select(){
        $res = $this->db->query($this->options);
		return $res;
	}
    public function field($fields){
        $this->options['field'] = $fields;
        return $this;
    }
    public function from($tables){
        $this->options['table'] = $tables;
		return $this;
	}
    public function where($where){
        $this->options['where'] = $where;
		return $this;
	}
    public function limit($limit){
        $this->options['limit'] = $limit;
        return $this;
    }

    public function query($query){
        if(!is_string($query)) throw new Error_Bphp("The 'query' param must be string");
        $res = $this->db->query($query);
        return $res;
    }

    public function execute($query){
        if(!is_string($query)) throw new Error_Bphp("The 'query' param must be string");
        $res = $this->db->execute($query);
        return $res;
    }

	public function __destruct(){
		if($this->con)
			mysql_close($this->con);
	}

}