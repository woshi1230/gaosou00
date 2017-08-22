<?php
class GoogleUrlApi {
      function GoogleUrlApi($key,$apiURL = 'https://www.googleapis.com/urlshortener/v1/url') {
          $this->apiURL = $apiURL.'?key='.$key;
    }
    function shorten($url) {
        $response = $this->send($url);
        return isset($response['id']) ? $response['id'] : false;
    }
    function expand($url) {
        $response = $this->send($url,false);
        return isset($response['longUrl']) ? $response['longUrl'] : false;
    }
    function send($url,$shorten = true) {
        $ch = curl_init();
        if($shorten) {
            curl_setopt($ch,CURLOPT_URL,$this->apiURL);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$url)));
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
        }
        else {
            curl_setopt($ch,CURLOPT_URL,$this->apiURL.'&shortUrl='.$url);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }
}
?>