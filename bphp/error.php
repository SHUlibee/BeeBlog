<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-1-31
 * Time: 下午4:06
 */
class Error_Bphp extends Exception{
    public function echoError(){
        $str = "
            <h3>Error in $this->file at line $this->line : $this->message</h3><hr />
        ";
        echo $str;
    }
}