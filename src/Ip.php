<?php

class Ip
{
    private $ip          = null;
    private $serviceUrl  = 'http://ip-api.com/json';
    public $error        = false;
    public $errorMessage = null;
    private $curlMethod  = "GET";
    public $response     = null;
    public $data         = null;
    public function __construct($ip){
        try{
            if($ip && filter_var($ip, FILTER_VALIDATE_IP)){
                $this->ip = $ip;
            } else{
                $this->error        = true;
                $this->errorMessage = 'Invalid IP address';
            }
        } catch(Exception $e){
            $this->error        = true;
            $this->errorMessage = $e->getMessage()." - ".$e->getFile()." - ".$e->getLine();
        }
    }

    private function getErrorMessage(){
        return $this->errorMessage;
    }

    public function getIp(){
        if(!$this->error){
            return $this->ip;
        } else{
            return $this->errorMessage;
        }
    }

    public function getServiceUrl(){
        if(!$this->error){
            return $this->serviceUrl.'/'.$this->getIp();
        } else{
            return $this->errorMessage;
        }
    }

    public function info(){
        $this->curlMethod = 'GET';
        return $this->run();
    }

    public function run(){
        try
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->getServiceUrl(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $this->curlMethod,
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $this->response = $response;
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->error = true;
            $this->errorMessage = 'Curl error: '.$this->getErrorMessage();
            echo "Bir hata oluştu: " . $e->getMessage();
            return null;
        }
    }
}
