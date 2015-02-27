﻿<?php

class User_Model extends Model_Lib{
	

	
	public function __construct(){
		parent::__construct('local');

        $this->tb_user = $this->prefix.'user';
        $this->tb_role = $this->prefix.'role';
        $this->tb_right = $this->prefix.'right';
	}
	
	public function get_user(){
		
		$sql = "select * from $this->tb_user";
		
		$res = $this->get($sql);
		return $res;
	}
	
	public function get_user_by_account($account){
		$sql = "select * from $this->tb_user where account = '$account'";

		$res = $this->get($sql);
		return isset($res[0]) ? $res[0] : NULL;
	}
	
	public function insert_user(){
		$sql = "insert into $this->tb_user (account, name, email) values('dfs','fffff','eeee@ddddd.com')";
		
		$res = $this->excute($sql);
		return $res;
	}

    public function get_role(){
        $sql = "select * from $this->tb_role";

        $res = $this->get($sql);
        return $res;
    }
    public function get_user_with_role($uid){
        $sql = "SELECT
                    uu.*, rr.name, rr.rights
                FROM
                    $this->tb_user uu
                JOIN $this->tb_role rr ON uu.role_id = rr.id
                WHERE
                    uu.id = $uid
                ";

        $res = $this->get($sql);
        return $res;
    }

}