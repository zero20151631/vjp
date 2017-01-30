<?php
/*
* 2017年1月6日 小咖秀代理
*/
// $url="http://v.xiaokaxiu.com/v/C30e0jj-Jr4cFEWHW6nCZA__.html";
header("Content-Type:text/html;charset=utf-8");
class Xiaokx {
    public static function getdata($url){
        preg_match("|v/(.*)\.html|", $url, $vids);
        if ($vids) {
            $vid = $vids[1];
            $apiurl = "http://api.xiaokaxiu.com/video/web/get_play_video?scid=".$vid;
            $info = self::get_curl_contents($apiurl);
            $jdata = json_decode($info);
            $title = $jdata->data->title;
            $downlink = $jdata->data->linkurl;
            if ($downlink) {
                $xml["title"] = $title;
                $xml["downlink"] = $downlink;
                return $xml;
            }
            return ">_< 视频地址获取失败";
        }
        return ">_< id获取失败";
    }
    //curl方法
    public static function get_curl_contents($url) {
        if (!function_exists("curl_init")){
            echo "php.ini未开启php_curl.dll";
            exit;
        }
        $cweb = curl_init();
        curl_setopt($cweb, CURLOPT_URL, $url);
        curl_setopt($cweb, CURLOPT_HEADER, 0);
        curl_setopt($cweb, CURLOPT_RETURNTRANSFER, 1);
        $httpheader = array(
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Language:zh-CN,zh;q=0.8",
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
    $stobj = new Xiaokx();
    $data = $stobj->getdata($url);
    getouttxt($data);
    return;
}
?>
