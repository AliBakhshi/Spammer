<?php
set_time_limit(0);
require "AutoLoader.php";
$onlineSpammer = new \Spammer\onlineSpammer();

$proxy=$onlineSpammer->randomProxyFinder($onlineSpammer->getFileContentByEnter(dirname(__FILE__).'/proxyList.txt'));


for($i=0;$i<1000;$i++) {

    $firstname = $onlineSpammer->createRandomWrods(5);
    $lastname = $onlineSpammer->createRandomWrods(6);
    $username = $onlineSpammer->createRandomWrods(6);
    $password = $onlineSpammer->createRandomWrods(10);
    $content = $onlineSpammer->createRandomWrods(100);
    $email = $onlineSpammer->createRandomWrods(6) . "@gmail.com";
    $month = rand(1, 11);
    $year = rand(1340, 1372);
    $day = rand(1, 28);
    $connectionNumberStatus = 1;
    $onlineSpammer->InsertData("INSERT INTO registerinfo (firstname, lastname, email,password, 	username,gender,month,day, year) VALUES ('$firstname', '$lastname', '$email','$password','$username','female','$month','$day','$year')");

    $res=$onlineSpammer->sendRequestCurl("firstname=".$firstname."&lastname=".$lastname."&username=".$username."&password=".$password."&email=".$email."&gender=female&born_on[year]=".$year."&born_on[month]=".$month."&born_on[day]=".$day,"http://www.domain.ir/user/register",false,$proxy);

    if($res['code']==200) {
    $connectionNumberStatus++;
    $res=$onlineSpammer->sendRequestCurl("username=$email&password=$password","http://www.domain.ir/user/login",false,$proxy);
    }else{
    die("One Of Connections Faild ! Number : ".$connectionNumberStatus);
    }
	
    $res=$onlineSpammer->sendRequestCurl("answer[]=2","http://www.domain.ir/poll/cast_vote/S_JLnwNnQ-dl25yXHjq-Mc6GN59SoMbPGd3emdQRbrk:",false,$proxy);
    if($res['code']!=200) {
        die("One Of Connections Faild ! Number : ".$connectionNumberStatus);
    }


    if($res['code']==200) {
    $connectionNumberStatus++;
    $res=$onlineSpammer->sendRequestCurl("","http://www.domain.ir/user/logout",false,$proxy,"get");
    }else{
    die("One Of Connections Faild ! Number : ".$connectionNumberStatus." Round : "+$i);
    }

    if($res['code']==307 || $res['code']==200) {
    if($i>=199){
    echo $res['result']+"<br><br><br>";
    }
    }else{
    die("One Of Connections Faild ! Number : ".$connectionNumberStatus);
    }


    echo $res['result'];

    sleep(1);


}
