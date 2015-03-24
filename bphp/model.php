<?php
/**
 * 处理模型
 * @author bee
 */
class Model_Bphp{

	/**
	 * 数据库
	 */
	protected $db_name = 'default';

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

	/**
	 * insert or delete or update 查询
	 * @param string $query 当参数为空或者不传时，采用构造查询的形式
	 * @return int
	 */
	protected function excute($query = ''){

		if($query) $this->query = $query;

		return mysql_query($this->query);
	}


	protected function select(){

		return $this;
	}
	protected function from(){

		return $this;
	}
	protected function where(){

		return $this;
	}

	public function __destruct(){
		if($this->con)
			mysql_close($this->con);
	}

}