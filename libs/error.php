<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-1-31
 * Time: 下午4:06
 */
class Error_Lib extends Exception{
    public function echoError(){
        $str = "
            Error in $this->file at line $this->line : $this->message
        ";
        echo $str;
    }
}