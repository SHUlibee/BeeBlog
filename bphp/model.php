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

	public function __construct($db_name = ''){
		include_once(SERVER_ROOT.'/config/database.php');

		$this->link = $DB;
        $this->prefix = $DB[$db_name]['prefix'];
		if(isset($this->link[$db_name])){
			$this->connect_db($db_name);
		}else{
			die("$db_name does not exist!");
		}
	}

	private function connect_db($db_name = ''){

		if(empty($db_name)){
			$db_name = $this->db_name;
		}

		$this->con = mysql_connect(
			$this->link[$db_name]['hostname'],
			$this->link[$db_name]['username'],
			$this->link[$db_name]['password']);

		if(!$this->con) die("Could not connect :".mysql_error());

		if(!mysql_select_db($this->link[$db_name]['database'], $this->con))
            throw new Exception('Could not connect DB you had set :'.mysql_error());
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