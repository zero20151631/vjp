<?php
/*
* 2017年1月6日 秒拍代理
*/
header("Content-Type:text/html;charset=utf-8");
class MiaoPai {
    public static function getmp($url){
        $urllists = explode("/", $url);
        $mpid = str_replace(".htm", "", $urllists[4]);
        if (isset($mpid)) {
            $api_url = "http://api.miaopai.com/m/v2_channel.json?fillType=259&scid=".$mpid."&vend=miaopai";
            $info = self::get_curl_contents($api_url);
            $jdata = json_decode($info);
            if ($jdata) {
                $result = $jdata->result;
                $title = $result->ext->t;
                $stream_base = $result->stream->base;
                $xml["title"] = $title;
                $xml["downlink"] = $stream_base;
                return $xml;
            }
            return ">_< 视频地址获取失败";
        }
        return ">_< id获取失败";
    }
    //curl方法
    public static function get_curl_contents($url){
        if(!function_exists("curl_init")){
            die("php.ini未开启php_curl.dll");
        }
        $cweb = curl_init(); 
        curl_setopt($cweb,CURLOPT_URL,$url);
        curl_setopt($cweb,CURLOPT_HEADER,0);
        curl_setopt($cweb,CURLOPT_RETURNTRANSFER, 1);
        $httpheader = array(
            "Accept: */*",
            "Accept-Language:zh-CN,zh;q=0.8",
            "User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36",
            "Content-Type:application/x-www-form-urlencoded; charset=utf-8"
        );
        curl_setopt($cweb, CURLOPT_HTTPHEADER, $httpheader);
        $cnt = curl_exec($cweb);
        curl_close($cweb);
        return $cnt; 
    }
}
function getouttxt($data){
    header("Location:".$data["downlink"]);
    return;
}
$url = $_GET["url"];
if ($url) {
    $stobj = new MiaoPai();
    $data = $stobj->getmp($url);
    getouttxt($data);
    return;
}
?>
