<?php
/*
 * Author : www.ali-bakhshi.ir
 * Spammer Class
 */
namespace Spammer;

use Database\databaseModel;

class onlineSpammer extends databaseModel {

    function sendRequestCurl($post="",$url,$proxyStatus=false,$proxyIp=null,$method="post",$userAgent="Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0"){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookies.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookies.txt');
        if($proxyStatus===true){
            curl_setopt($ch, CURLOPT_PROXY,$proxyIp);
            //Our Proxy List Has No Additional Information
            //curl_setopt($ch, CURLOPT_PROXYPORT, '8080');
            //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            //curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'USERNAME:PASSWORD');
        }
        curl_setopt($ch,CURLOPT_URL,$url);
        if($method=="post"){
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
        }else{
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT,$userAgent);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, true);
        //curl_setopt($ch, CURLOPT_NOBODY, true);
        //curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        $res = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ['result'=>$res,'code'=>$httpcode];
    }

    function createRandomWrods($limit=null,$wordsArray=["A","a","B","b","C","c","d","D","1","2","4","5","2","8","Z","z","p","P","r","t","W","V","j","L","l"]){
        if(is_null($limit)){
            $limit=count($wordsArray);
        }
        $result="";
        for($i=0;$i<$limit;$i++){
            $result.=$wordsArray[rand(0,count($wordsArray)-1)];
        }
        return $result;
    }



    function getFileContentByEnter($filePath){
        $fileOpen = fopen($filePath,"r") or die("Unable to open file!");
        $result = explode("\n",fread($fileOpen,filesize($filePath)));
        fclose($fileOpen);
        return $result;
    }

    function randomProxyFinder($proxyList){

        if(is_array($proxyList)){
            return $proxyList[rand(0,(count($proxyList)-1))];
        }else{
            die("Proxy List Is Invild !");
        }

    }

}

