<?php
/*
* 2017年1月6日 小影代理
*/
// $url = "http://www.xiaoying.tv/v/a9ar5/1";
header("Content-Type:text/html;charset=utf-8");
class Xiaoying {
    public static function getdata($url){
        $list = explode("/", $url);
        $puid = $list[4];
        $ver = $list[5];
        if ($puid) {
            $cookie = $puid."_".$ver."_".(time()+rand(1000,2000))."_".rand(0,9);
            $weburl = "http://w.api.xiaoying.co/webapi2/rest/video/videourl?callback=videocallbackvideosrc&appkey=30000000&puid=".$puid."&ver=".$ver."&sign=0&useragent=%E5%A1%AB%E5%85%A5%E8%8E%B7%E5%8F%96%E7%9A%84%E4%BF%A1%E6%81%AF&usercurrentdevice=%E5%A1%AB%E5%85%A5%E8%8E%B7%E5%8F%96%E7%9A%84%E4%BF%A1%E6%81%AF&devicesign=%E5%A1%AB%E5%85%A5%E8%8E%B7%E5%8F%96%E7%9A%84%E4%BF%A1%E6%81%AF&format=MP4&cookie=".$cookie."&fromApp%5Btype%5D=2&fromApp%5Bname%5D=%E5%B0%8F%E5%BD%B1&_=".time();
            $data = self::get_curl_contents($weburl);
            $data = str_replace(array("videocallbackvideosrc(",")"), array("",""),$data);
            $jdata = json_decode($data);
            $downlink = $jdata->url;
            if ($downlink) {
                $xml["title"] = null;
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
    $stobj = new Xiaoying();
    $data = $stobj->getdata($url);
    getouttxt($data);
    return;
}
?>
