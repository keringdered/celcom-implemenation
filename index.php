<?php
  require_once "./Messaging.php";
$partnerID = "xxx";
$apikey = "62cbf27c4ae1apikeysa7eb5fc5b1f93701a6ac4";
$shortcode = "INFOTEXT";

$gateway = new Messaging($apikey,$shortcode,$partnerID);
/*get balances*/
/*$balance = $gateway->account_balance();
print_r($balance);*/
/*get delivery report*/
/*$delivery = $gateway->delivery_report(9859737770);
print_r($delivery);*/

/*send message*/
/*$message = $gateway->send("254712345678","Message from a refactored class using get method");
print_r($message);
$message =  $gateway->send("254712345678","Message from a refactored class using POST method");
print_r($message);*/
$response = '{"responses":[{"respose-code":200,"response-description":"Success","mobile":254713482448,"messageid":8290842,"networkid":"1"},{"respose-code":200,"response-description":"Success","mobile":254713482448,"messageid":8290843,"networkid":"1"}]}';
$responses = json_decode($response,true);
foreach ($responses as $response){
    foreach ($response as $result){
        if(array_key_exists('respose-code',$result)){
            echo "<pre/>";
            echo "With Typo";
            print_r($result['respose-code']);
        }if(array_key_exists('response-code',$result)){
            echo "<pre/>";
            echo "Without typo";
            print_r($result['response-code']);
        }
    }
}

