# Introduction
Celcom Africa is a company that provide Bulk SMS & USSD service to enterprises.Having started using this service i tried to come up with the easiest way a developer can integrated this service in a PHP environment and as a result this small light weight library came into being. The library allows the developer in question to get account balance,send text message using both POST and GET methods,schedule a text message to be send at a later time or date and customize or personalize the text message based on provided options.
# Prerequisite
You should:
* Be registered with Celcom Africa
* Have a valid API Key 
* Have the correct partner id
# Usage
* Clone this repository. In your terminal type the following and hit enter.
```php
    git clone https://github.com/keringdered/celcom-implemenation.git
``` 
* After cloning,go to the file that you want to implement this or utilize this package and import the Gateway.php file as follows:
```php
    <?php
    require_once ("./Gateway.php");
    /*Initialize the gateway. Make sure the variables below have valid values*/
    $api_key = "";$short_code ="";$partner_id="";
    $gateway = new Gateway($api_key,$short_code,$partner_id);
```
* Available methods and usage
    * To get account balance
    ```php
    <?php
        require_once ("./Gateway.php");
        /*Initialize the gateway. Make sure the variables below have valid values*/
        $api_key = "";$short_code ="";$partner_id="";
        $gateway = new Gateway($api_key,$short_code,$partner_id);
        $response = $gateway->account_balance();
    ```
    * To get send message via POST
      ```php
            <?php
             $message = "This is a message sent via POST Method.";
             $mobile ="254715404451";
             $response = $gateway->send($mobile,$message,'POST');
      ```
     * To send text message via GET
        ```php
                 <?php
                  $message = "This is a message sent via GET Method.";
                  $mobile ="254715404451";
                  $response = $gateway->send($mobile,$message);
        ```
    * To send a scheduled text message. By default this will be send via POST method 
            
         ```php
        <?php
             $message = "This is a scheduled message.";
             $mobile ="254715404451";
              $time = time()+30*60*60;/*Scheduled to be send in 30 mins time*/
             $response = $gateway->schedule($mobile,$message,$time);
         ```
    * To get message delivery report
        ```php
         <?php
          $message_id = 345667;
          $response = $gateway->delivery_report($message_id);
        ```
    * To get message delivery report
      ```php
         <?php
          $data = array('phone_number'=>254713482448,'first_name'=>'John', 'last_name'=>"Doe");
          $message = "Hi {first_name} {last_name}, please get the message sent to {phone_number}" ;
          $customized_message = $gateway->customize_message($data,"{first_name}",$message);
          $customized_message = $gateway->customize_message($data,"{last_name}",$customized_message);
          $customized_message = $gateway->customize_message($data,"{phone_number}",$customized_message);
        /*The return message will be: Hi John Doe, please get the message sent to 254713482448*/ 
    
      ```
    * This is the format of all the responses and how one can utilize them
    ```php
    <?php
  $response = '{"responses":[{"respose-code":200,"response-description":"Success","mobile":254713482448,"messageid":8290842,"networkid":"1"},{"respose-code":200,"response-description":"Success","mobile":254713482448,"messageid":8290843,"networkid":"1"}]}';
    $responses = json_decode($response,true);
    foreach ($responses as $response){
        foreach ($response as $result){
      /*    unfortunately the api response is inconsistent and has a typo in other 'response-code' key. 
        *so we do array_key_exists() to be sure of what we use a response code
        */
          if(array_key_exists('respose-code',$result)){
                $response_code =$result['respose-code'];
            }if(array_key_exists('response-code',$result)){
                $response_code = $result['response-code'];
            }
        $result ['response-description'];$result['messageid'];   $result['mobile'];$result['networkid'];
        }
  }
  ```
    
        
# Author
* GitHub @[KeringDeRed](https://github.com/keringdered)
# Licence
* [MIT](https://opensource.org/licenses/MIT)
