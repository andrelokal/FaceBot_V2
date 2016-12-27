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
    public function __construct(){

        $this->tokenFacebook = "EAADDp1NdEqEBAPTcuNPMcaLdZBAxcUyYaYlSibtHRWXUmN05freck99EhGoOSi9xxigE0HyGOCS5mwRl08KM6cc8rNZCmrXI1VAcMky6dM0cMZC4K8oLZCR7Jh0O0HpWe262Am5eLuvsQjx0hSGZCSdQFXzyzExAHYgtrlhYKBAZDZD";    
    
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
    
    /** Metodo para enviara mensagens para o facebook */
    public function sendMessage($parameters) {
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($parameters),
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
