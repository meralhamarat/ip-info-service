<?php

class Ip
{
    private $ip          = null;
    private $serviceUrl  = 'http://ip-api.com/json/';
    public $error        = false;
    public $errorMessage = null;
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
            return $this->serviceUrl.$this->getIp();
        } else{
            return $this->errorMessage;
        }
    }

    public function info(){

    }

    public function run(){

    }
}