<?php

    function processMessage($message) {
        
        global $objFace, $objComponent, $objLog;
                
        $dadosUser = $objLog->getData();
        
        $dadosUser['robo'] = 1; //Seta a rota escolhida pelo usuario
        
        $array = array(
               0=>"Vamos come�ar!", 
               1=>"Voc� estar� acompanhado?", 
               2=>"Em qual loja ou cidade voc� deseja retirar o ve�culo?", 
               3=>"Certo. Deseja devolver o carro na mesma loja?",
               4=>"Quando voc� deseja retirar o ve�culo?\n\nExemplo: (".date("d/m/Y 10:00").") ",
               5=>"Certo. Qual ser� a data de devolu��o?\n\nExemplo: (".date("d/m/Y 10:00").") ",
               6=>"Achamos que esses acess�rios/servi�os ser�o �teis para voc�!",
               7=>"Por favor, informe o seu CPF.",
               8=>"Por favor, informe o seu Email.",
               9=>"{$dadosUser['profile']['first_name']}, veja o resumo de sua reserva abaixo:");
        
        $sender = $message['sender']['id'];
        $text = $message['message']['text'];
        

        
        if(is_array($dadosUser)){

            if(isset($dadosUser['passo']) && $dadosUser['passo'] < 9){
                if (isset($text)){
                    $dadosUser['resp'][$dadosUser['passo']] = $text;     
                } 
                $dadosUser['passo'] = $dadosUser['passo'] + 1;
                
                $objLog->setData($dadosUser);
                
                $objFace->sendMessage(array('recipient' => array('id' => $sender),'message' => array('text' => utf8_encode($array[$dadosUser['passo']]))));
                if($dadosUser['passo'] >= 9){
                   $dadosUser['robo'] = '';
                   $objLog->setData($dadosUser); 
                }
          
            }else{
                $dadosUser['passo'] = 0;
                $dadosUser['profile'] = $objFace->getData($sender);
                $objLog->setData($dadosUser);
                $objFace->sendMessage(array('recipient' => array('id' => $sender),'message' => array('text' => utf8_encode($array[0]))));    
            }
            
        }else{
            $dadosUser['passo'] = 0;
            $dadosUser['profile'] = $objFace->getData($sender);
            $objLog->setData($dadosUser);
            $objFace->sendMessage(array('recipient' => array('id' => $sender), 
                                        'message' => array('text' => utf8_encode($array[0]))));    
        }

    }

    if (isset($update['entry'][0]['messaging'][0])) {
        processMessage($update['entry'][0]['messaging'][0]);
    }

?>
