<?php
/**
 * Created by PhpStorm.
 * User: bee
 * Date: 15-3-31
 * Time: 下午5:44
 */

define('GT_API_SERVER', 'http://api.geetest.com');
define('GT_SDK_VERSION', 'php_2.0');
class Geetest_Helper{

    private $captcha_id = '2ff982fb4d3c7474fe2ce8157798acfc';
    private $private_key = 'e2d4b3e9ea7f0f04b1b085e16404697b';
    private $challenge = '';

    function __construct() {
    }

    function setCaptchaid($captcha_id) {
        $this->captcha_id = $captcha_id;
    }

    function setPrivatekey($private_key) {
        $this->private_key = $private_key;
    }

    function register() {
        $this->challenge = $this->_send_request("/register.php", array("gt"=>$this->captcha_id));
        if (strlen($this->challenge) != 32) {
            return 0;
        }
        return 1;
    }

    function getWidget($product="", $popupbtnid="") {
        $params = array(
            "gt" => $this->captcha_id,
            "challenge" => $this->challenge,
            "product" => $product,
            "sdk" => GT_SDK_VERSION,
        );
        if ($product == "popup") {
            $params["popupbtnid"] = $popupbtnid;
        }
        return "<script type='text/javascript' src='".GT_API_SERVER."/get.php?".http_build_query($params)."'></script>";
    }

    function validate() {
        if (isset($_POST['geetest_challenge']) && isset($_POST['geetest_validate']) && isset($_POST['geetest_seccode'])) {
            $challenge = $_POST['geetest_challenge'];
            $validate = $_POST['geetest_validate'];
            $seccode = $_POST['geetest_seccode'];
        }else {
            return FALSE;
        }
        if ( ! $this->_check_validate($challenge, $validate)) {
            return FALSE;
        }

        $codevalidate = $this->_send_request("/validate.php", array("seccode"=>$seccode), "POST");
        if (strlen($codevalidate)>0 && $codevalidate==md5($seccode)) {
            return TRUE;
        } else if ($codevalidate == "false"){
            return FALSE;
        } else {
            return $codevalidate;
        }
    }

    private function _check_validate($challenge, $validate) {
        if (strlen($validate) != 32) {
            return FALSE;
        }
        if (md5($this->private_key.'geetest'.$challenge) != $validate) {
            return FALSE;
        }
        return TRUE;
    }

    private function _send_request($path, $data, $method="GET") {
        $data['sdk'] = GT_SDK_VERSION;

        if ($method=="GET") {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'timeout'=>2,
                )
            );
            $context = stream_context_create($opts);
            $response = file_get_contents(GT_API_SERVER.$path."?".http_build_query($data), false, $context);

        } else {
            $opts = array(
                'http' => array(
                    'method' => "POST",
                    'content' => http_build_query($data),
                )
            );
            $context = stream_context_create($opts);
            $response = file_get_contents(GT_API_SERVER.$path, false, $context);
        }
        return $response;
    }
}