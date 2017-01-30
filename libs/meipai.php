<?php
/*
* 2016年1月27日 美拍代理
* update 2017年1月6日
*/
// $url="http://www.meipai.com/media/466938314";
header("Content-Type:text/html;charset=utf-8");
class Meipai {
    public static function getmp($url){
        $urllists = explode("/", $url);
        $mpid = $urllists[4];
        if (isset($mpid) && is_numeric($mpid)) {
            $info = self::get_curl_contents($url);
            preg_match("|data-video=\"(.*?)\">|", $info,$meituurl);
            preg_match("|<meta content=\"(.*?)\" property=\"og:title\">|", $info,$title);
            if ($meituurl) {
                $title = $title[1];
                $downlink = $meituurl[1];
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
    $stobj = new Meipai();
    $data = $stobj->getmp($url);
    getouttxt($data);
    return;
}
?>
