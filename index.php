<?php
  require_once "./Gateway.php";
  /*change these details to your actual values*/
$partnerID = "96390u8";
$apikey = "62cbf27c4ae171234567eb5fc5b1f93701a6ac4";
$shortcode = "INFOTEXT";

$gateway = new Gateway($apikey,$shortcode,$partnerID);
if(isset($_GET['view'])){
    $view = $_GET['view'];
   switch ($view){

       case 'report':
           /*get delivery report*/
           $delivery = $gateway->delivery_report(99064191);
           print_r($delivery);
           break;
       case 'send-get':
           /*send message*/
           $message = $gateway->send("254712345678","Message from a refactored class using get method");
           print_r($message);
           break;
       case 'send-post':
           $message =  $gateway->send("254712345678","Message from a refactored class using POST method");
           print_r($message);
           break;
       default:
           /*get balances*/
           $balance = $gateway->account_balance();
           print_r($balance);
           break;
   }
}else{
    echo "Please copy paste the following urls to your address bar.<br/>";
    echo "1. ?view=balance<br/>";
    echo "2. ?view=report<br/>";
    echo "3. ?view=send-get<br/>";
    echo "4. ?view=send-post<br/>";
}

$response = '{"responses":[{"respose-code":200,"response-description":"Success","mobile":254713482448,"messageid":8290842,"networkid":"1"},{"respose-code":200,"response-description":"Success","mobile":254713482448,"messageid":8290843,"networkid":"1"}]}';
$responses = json_decode($response,true);
foreach ($responses as $response){
    foreach ($response as $result){
        if(array_key_exists('respose-code',$result)){
            /*echo "<pre/>";
            echo "With Typo";
            print_r($result['respose-code']);*/
        }if(array_key_exists('response-code',$result)){
            /*echo "<pre/>";
            echo "Without typo";
            print_r($result['response-code']);*/
        }
    }
}

