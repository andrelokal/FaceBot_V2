<?php
/**
 * Components
 * ABSTRAวรO DE FERRAMENTAS PARA O FACEBOOK
 * @author      Andr้ Martos
 * @version     1.0
 * @date        15/12/2016
 */

class Components {

    
    
    public function __construct(){ 
    }
    
    
    public function createButtons($title, $arr) {
        $payload = array ();
        $payload['template_type'] = "button";
        if (!empty($title)) {
            $payload['text'] = $title;
        }
        $payload['buttons'] = array ();
        foreach ($arr as $key => $value) {
            if (substr($value, 0, 4) === "http") {
                array_push($payload['buttons'], array (
                    "type" => "web_url",
                    "title" => $key,
                    "url" => $value
                ));
            } else {
                array_push($payload['buttons'], array (
                    "type" => "postback",
                    "title" => $key,
                    "payload" => $value
                ));
            }
        }
        return $payload;
    }
    
    
    public function createBooleanButtons($texto){
        return $this->createButtons($texto,array("Sim"=>"OPT_SIM",utf8_encode("Nใo")=>"OPT_NAO"));
    }
    
    
    public function createFile($url) {
        $payload = array ();
        $payload['type']='file';
        $payload['payload'] = array('url'=>$url);
        return $payload;
    }
    
    
    public function createQuickReplies ($title, $arr) {
        $i = 0;
        $qrs = array ();
        foreach ($arr as $key => $value) {
            $i = $i + 1;
            if ($i > 10) {
                break;
            }
            array_push($qrs, array (
                "content_type" => "text",
                "title" => (strlen($key) > 19) ? substr($key,0,16).'...' : $key,
                "payload" => $value
            ));
        }

        $bot_resp = array ();
        $bot_resp['text'] = $title;
        $bot_resp['quick_replies'] = $qrs;
        return $bot_resp;
    }
    
    
    //gera um comando dizendo que o bot esta digitando.
    function typing_on(){
        sendReply(array('sender_action'=>'typing_on'));
    }

    
}



?>