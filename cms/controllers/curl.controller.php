<?php

class CurlController
{
    /*=================================================
                Peticiones a la api 
    ===================================================*/

    static public function request($url,$method,$fields){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://cms-builder-api.com/'.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                'Authorization: fga45dsfg34fhfgj456erFGHDRG6546hd564fhdf'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        return $response;

    }
}
