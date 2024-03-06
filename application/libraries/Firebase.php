<?php

class Firebase
{
    private   $LegacyServerKey = 'AAAAe7hU7gg:APA91bESazvbCVVGB5Q8eUePgJki5Wf8fqQZGiPz63NRyalC9_gvsYRCcT81I8tSMgAA8mzI-ypBrH4PbWkLh-bBz8zpVotKLmSflLoH-cp0ye51SKg6xmo9F1DBuXjrudWzJzV5aSIJ';
    private  $URL = 'https://fcm.googleapis.com/fcm/send';
    
    public function __construct() {
    }

    public function post($registration_ids = array(),$notification = array(),$data = array()) {
        if (!empty($notification) && !empty($registration_ids)) {
            $fields = array(
                "notification"=>$notification,
                "priority"=> "high",
                "registration_ids" =>$registration_ids,
                "data" =>$data
            );

            $headers = array (
                'Content-Type: application/json',
                'Authorization: key = '.$this->LegacyServerKey,
            );

            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $this->URL);
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            return $result;
        } else {
            return false;
        }
    }

    public function post_with_topics($topics = array(),$notification = array(),$data = array()) {
        if (!empty($topics) && !empty($notification)) {
            $fields = array (
                "notification"=>$notification,
                "condition"=> "'offers' in topics",
                "priority"=> "high",
                "data" =>$data,
            );

            $headers = array (
                'Content-Type: application/json',
                'Authorization: key = '.$this->LegacyServerKey,
            );

            // Send Reponse To FireBase Server
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $this->URL);
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            return $result;
        } else {
            return false;
        }
    }
}