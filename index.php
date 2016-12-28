<?php
//include('testes/index_BSmith.php');
   
    //INCLUDES
    require_once('model/FacebookHelper.php');
    require_once('model/Components.php');
    require_once('model/ArqLog.php');
    require_once('model/Validation.php');

    $objComponent = new Components();
    $objFace = new FacebookHelper();
    $objValida = new Validation("util/validators.php");
    
    
    //Autenticação do Facebook
    echo $objFace->getAuthentication($_REQUEST);
    
    //todo: Verificar melhor forma de deixar as variaveis principais disponíveis em todo o sistema
    $update_response = file_get_contents("php://input");
    $update = json_decode($update_response, true);
    $message = $update['entry'][0]['messaging'][0];
    $sender = $message['sender']['id'];
    $text = $message['message']['text'];
    
    
    if (isset($text)) {
       
        $objLog = new ArqLog($sender);
        
        $context = $objLog->getData();
        
        
        if(preg_match('[reserva|reservar|alugar|aluga]', strtolower($text)) || $context['robo'] == 'reserva'){
            include('script_bot/bot_reserva.php'); //todo: verificar a melhor forma de rotear para o arquivo certo!!!
        
        }else{
            //$objFace->sendMessage(array('recipient' => array('id' => $sender),'message' => array('text' => utf8_encode('Olá, o que você deseja fazer?'))));
            //$objFace->sendMessage($objComponent->createBooleanButtons("E ai"), $sender)
            
            $objFace->sendReply($objComponent->createFile("http://portal.mec.gov.br/seb/arquivos/pdf/Profa/apres.pdf"),$sender);
            //$objFace->sendReply("Teste",$sender);
             
        }
        
    
    }
    


?>
