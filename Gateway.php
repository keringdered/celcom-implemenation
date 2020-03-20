<?php


/**
 * Class Gateway
 */
class Gateway
{
    /**
     * @var $api_key
     * @var $shortcode
     * @var $partner_id
     * @var $api_endpoint
     * @var $account_balance_endpoint
     * @var $delivery_report_endpoint
     */
    protected $api_key;
    protected $shortcode;
    protected $partner_id;
    protected  $api_endpoint = "https://mysms.celcomafrica.com/api/services/sendsms/";
    protected $account_balance_endpoint = "https://mysms.celcomafrica.com/api/services/getbalance/";
    protected $delivery_report_endpoint = 'https://mysms.celcomafrica.com/api/services/getdlr/';

    /**
     * Gateway constructor.
     * @param $api_key
     * @param $shortcode
     * @param $partner_id
     */
    public function __construct($api_key, $shortcode, $partner_id)
    {
        $this->shortcode = $shortcode;
        $this->api_key = $api_key;
        $this->partner_id = $partner_id;
    }

    /**
     * @param $mobile
     * @param $message
     * @param string $method
     * @return mixed
     */
    public function send($mobile, $message, $method = "GET"){
        if($method =='GET'){
            $request ="?apikey=" . urlencode($this->api_key) . "&partnerID=" . urlencode($this->partner_id) . "&message=" . urlencode($message) . "&shortcode=$this->shortcode&mobile=$mobile";
            $response = $this->send_get_request($request);
        }else{
            $request = array(
                'apikey'=>$this->api_key,
                'partnerID'=>$this->partner_id,
                'shortcode'=>$this->shortcode,
                'message'=>$message ,
                'mobile'=>$mobile
            );
            $request = json_encode($request); /*convert to json for processing*/
            $response = $this->send_post_request($request);
        }
        return $response;

    }

    /**
     * @param $request
     * @return mixed
     */
    public function send_post_request($request){
        $url = $this->api_endpoint;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json')) ;
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        $response = curl_exec($curl);
        $result = json_decode($response,true);
        return $result;
        
    }

    /**
     * @param $request
     * @return mixed
     */
    public function send_get_request($request){
        $url = $this->api_endpoint.$request;
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response,true);
        return $result;
           
    }

    /**
     * @param $message_id
     * @return mixed
     */
    public function delivery_report($message_id){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->delivery_report_endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); //setting custom header
        $request = array(
            //Fill in the request parameters with valid values
            'partnerID' => $this->partner_id,
            'apikey' => $this->api_key,
            'messageID' => $message_id,
        );
        $data_string = json_encode($request);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $response = curl_exec($curl);
        $result = json_decode($response,true);
        return $result;
    }

    /**
     * @return mixed
     */
    public function account_balance(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->account_balance_endpoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); //setting custom header
        $request = array(
            'partnerID' => $this->partner_id,
            'apikey' => $this->api_key,
        );

        $data_string = json_encode($request);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $response = curl_exec($curl);
        $result = json_decode($response,true);
       return $result ;
    }

    /**
     * @param $message
     * @param $mobile
     * @param $time
     * @return mixed
     */
    public function schedule($message, $mobile, $time){
        $request = array(
            'apikey'=>$this->api_key,
            'partnerID'=>$this->partner_id,
            'shortcode'=>$this->shortcode,
            'message'=>$message ,
            'mobile'=>$mobile ,
            'timeToSend'=>$time /*timestamp or datetime*/
        );
        $request = json_encode($request); /*convert to json for processing*/
        $response = $this->send_post_request($request);
        return $response;
    }

    /**
     * @param $data
     * @param $term
     * @param $message
     * @return mixed|string
     */
    public function customize_message($data, $term, $message){
        if(!$message){
            return "";
        }
        $term_index = str_replace("{",'',str_replace("}",'',$term));
        if(array_key_exists($term_index,$data)){
            $message = str_replace($term,$data[$term_index],$message);
        }
        return $message;
    }
}