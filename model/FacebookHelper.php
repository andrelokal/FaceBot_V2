<?php
/**
 * FacebookHelper
 * INTERFACE DE COMUNICAÇÃO COM O FACEBOOK
 * @author      André Martos
 * @version     1.0
 * @date        14/12/2016
 */

 class FacebookHelper {
 
    private $tokenFacebook = "";
    private $apiUrl = ""; 
    public $tokenAplication = "movidabot2";    
    
    // Quando a Classe é Instaciada ela automaticamente verifica se a chamada partiu de produção ou homologação e define o token de resposta
    public function __construct($chave = ""){
        if($_SERVER['HTTP_HOST']=='bot.movida.com.br'){
            $this->tokenFacebook = "EAAB2kQ7OmegBAFDI8UsXxYzxyLtGlx40MYBfFQZAZAl3ISPm2A1KUJxWZByO9GZAWcVxWCUZCboZBwTjJpgQq3X1ji7gkC4XRPdvkR6yJoYStIgkkVierKyejODley3gZABMabOqFHL3xfefrFMLB2kplRxl6f4rjFU4U94NGUXEAZDZD";
        }else{
            //$this->tokenFacebook = "EAAEV6MnZAtYQBAFmzMZC85B8wMcohjKNzwNZBmWfKbw14fgQ2NGL4MyHkPCORU1K887s8a64ZC6wZCJDkllPXpiMVr8PBp0AcqTWGuxOMqUO2qaroJzSyUgDLUa5mGv5PNUeKc6eQWRW8ZARFFQ9L7otAW70dlZCRZBc7ObqyNiPxQZDZD";
            $this->tokenFacebook = "EAACcxcXuiz8BABQZA6zcHIIrqY3ItMEFhNlxb3WZA14yfs3sx0yGr4yYhiWTNmZCOuQTxnwNWceLxytMedf0FEFLbxhtX60qfNGH5oO64ea1sL6vKd3Ipg6ZASCzWMZBlPY9pezc4lhSTSE7C79Ai9sOttyJyAySSjVD3vhKUAgZDZD";    
        }
        
        if($chave){
            $this->tokenFacebook = $chave;
        }
            
        
            
        $this->apiUrl = "https://graph.facebook.com/v2.6/me/messages?access_token=".$this->tokenFacebook;    
        
        
    }  
 
 
    //Autenticação do Faceboock
    public function getAuthentication($request){
        if(isset($request['hub_challenge'])) {
            $challenge = $request['hub_challenge'];
            $hub_verify_token = $request['hub_verify_token'];
            
            /**Segurança da aplicação desativado por enquanto
            * todo:configurar no facebook
            * 
            if ($hub_verify_token != $this->tokenAplication){
                return false;
            }
            */ 
            return $challenge;
        }  
    }
    
    /**
    * is_assoc
    * 
    * @param mixed $arr
    */
    private function is_assoc($arr) {
        return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
    }
    
    
    /** Metodo para enviara mensagens para o facebook */  
    public function sendReply($msg,$sender_id) {
        
        
        $arr = array ();
        
        if (is_string($msg)){
            $arr = array(
                "recipient" => array("id" => $sender_id),
                "message" => array("text" => $msg)
            );

        } 
        elseif ($this->is_assoc($msg) && (!empty($msg['template_type']))){
            $arr = array(
                "recipient" => array("id" => $sender_id),
                "message" => array(
                    "attachment" => array (
                        "type" => "template",
                        "payload" => $msg
                    )
                )
            );

        } 
        elseif ($this->is_assoc($msg) && (!empty($msg['quick_replies']))){
            $arr = array(
                "recipient" => array("id" => $sender_id),
                "message" => $msg
            );

        } 
        elseif ($this->is_assoc($msg) && (!empty($msg['payload']['url']))){
            $arr = array(
                "recipient" => array("id" => $sender_id),
                "message" => array(
                    "attachment" => $msg
                )
            );
        }
        elseif ($this->is_assoc($msg) && (!empty($msg['sender_action']))){
            $arr = array(
                "recipient" => array("id" => $sender_id),
                "sender_action" => $msg['sender_action']
                );
        }

        if (empty($arr)){
            error_log("Resposta inválida!");
            return;
        }
        
        
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($arr),
                'header'=>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
                )
            );
        $context  = stream_context_create( $options );
        file_get_contents($this->apiUrl, false, $context );
    }
    
    public function getData($sender_id){
            $DadosStr = file_get_contents('https://graph.facebook.com/v2.6/'.$sender_id.'?fields=first_name,last_name,profile_pic,locale,timezone,gender&access_token='.$this->tokenFacebook);
            return json_decode($DadosStr, true);
    }   
    


 }

?>
