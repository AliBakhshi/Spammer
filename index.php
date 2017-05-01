<?php
set_time_limit(0);
require "AutoLoader.php";

/* Usage Samples On php codeigniter Website Login And Register */

// Create Object From Spammer Class
$onlineSpammer = new \Spammer\onlineSpammer();

// Find Random Proxy From proxyList.txt
$proxy=$onlineSpammer->randomProxyFinder($onlineSpammer->getFileContentByEnter(dirname(__FILE__).'/proxyList.txt'));


// For Loop To Repeat Spamming 1000 Times !
for($i=0;$i<1000;$i++) {

    // Create Required Field In Target Register Form		
    $firstname = $onlineSpammer->createRandomWrods(5);
    $lastname = $onlineSpammer->createRandomWrods(6);
    $username = $onlineSpammer->createRandomWrods(6);
    $password = $onlineSpammer->createRandomWrods(10);
    $content = $onlineSpammer->createRandomWrods(100);
    $email = $onlineSpammer->createRandomWrods(6) . "@gmail.com";
    $month = rand(1, 11);
    $year = rand(1340, 1372);
    $day = rand(1, 28);
    // Set Level Of Connection For Debug , First Level Is Register ! 	
    $connectionNumberStatus = 1;
	
    // If You Want Store Users Register Information For Next Usage Uncomment This Line		
    // $onlineSpammer->InsertData("INSERT INTO registerinfo (firstname, lastname, email,password, 	username,gender,month,day, year) VALUES ('$firstname', '$lastname', '$email','$password','$username','female','$month','$day','$year')");

    // Send An Post Request For Register 	
    $res=$onlineSpammer->sendRequestCurl("firstname=".$firstname."&lastname=".$lastname."&username=".$username."&password=".$password."&email=".$email."&gender=female&born_on[year]=".$year."&born_on[month]=".$month."&born_on[day]=".$day,"http://www.domain.ir/user/register",false,$proxy);

    if($res['code']==200) {
    	// If Register Status Was Ok ++ And Go To Next Status	    
    	$connectionNumberStatus++;
    	// After Register Now We Need Login Request	    	
    	$res=$onlineSpammer->sendRequestCurl("username=$email&password=$password","http://www.domain.ir/user/login",false,$proxy);
    }else{
    	die("One Of Connections Faild ! Number : ".$connectionNumberStatus);
    }
	
    // After Login We Can Send Spam Comments	
    $res=$onlineSpammer->sendRequestCurl("answer[]=2","http://www.domain.ir/poll/cast_vote/S_JLnwNnQ-dl25yXHjq-Mc6GN59SoMbPGd3emdQRbrk:",false,$proxy);
    if($res['code']!=200) {
        die("One Of Connections Faild ! Number : ".$connectionNumberStatus);
    }

    //After Sending Comment We Must Log Out For Next Register Request In For Loop
    if($res['code']==200) {
    	$connectionNumberStatus++;
    	$res=$onlineSpammer->sendRequestCurl("","http://www.domain.ir/user/logout",false,$proxy,"get");
    }else{
    	die("One Of Connections Faild ! Number : ".$connectionNumberStatus." Round : "+$i);
    }

    // Echo Result After Each Register
    // echo $res['result'];
    // You Can Slow Proccess By Uncommenting Below Line To Prevent Spammer From Block And Firewall ... 	
    //sleep(1);


}
