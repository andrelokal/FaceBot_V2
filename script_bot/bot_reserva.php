<?php

    //processa mensagem
    function processMessage($message) {
        
        global $objFace, $objComponent, $objLog, $sender, $text, $objValida;
                
        $context = $objLog->getData();
        
        $context['robo'] = 'reserva'; //Seta a rota escolhida pelo usuario
        
        $arrQuestion = array(
               0=>"Vamos começar!", 
               1=>"Você estará acompanhado?", 
               2=>"Em qual loja ou cidade você deseja retirar o veículo?", 
               3=>"Certo. Deseja devolver o carro na mesma loja?",
               4=>"Quando você deseja retirar o veículo?\n\nExemplo: (".date("d/m/Y 10:00").") ",
               5=>"Certo. Qual será a data de devolução?\n\nExemplo: (".date("d/m/Y 10:00").") ",
               6=>"Achamos que esses acessórios/serviços serão úteis para você!",
               7=>"Por favor, informe o seu CPF.",
               8=>"Por favor, informe o seu Email.",
               9=>"{$context['profile']['first_name']}, veja o resumo de sua reserva abaixo:");

        //Verificação de inicio.
        if(!isset($context['passo'])){
            $context['passo'] = 0;
            $context['profile'] = $objFace->getData($sender);
            $objLog->setData($context);
            $objFace->sendReply(utf8_encode($arrQuestion[0]),$sender);
            exit;   
        }
  
        //Faz validação dos dados recebidos
        if(!$objValida->validarDados($text,"passo".$context['passo'])){
            $objFace->sendReply(utf8_encode($objValida->msg),$sender);
            exit;     
        }

        switch ($context['passo']){
            case "1":
                //tratamento dado ao passo 1    
            //break;
            case "2":
                //tratamento dado ao passo 2
            //break;
            case "3":
                //tratamento dado ao passo 3 ...
            //break;
        }

        $context['resp'][$context['passo']] = $text;     

        //Incrementa proximo passo
        $context['passo'] = $context['passo'] + 1;
        
        //Salva atualização de contexto
        $objLog->setData($context);
        
        //Envia proxima mensagem
        $objFace->sendReply(utf8_encode($arrQuestion[$context['passo']]),$sender);
        
        
        //Verifica Fim de Conversa
        if($context['passo'] == 9){
           $context = array();
           $context['robo'] = '';
           $objLog->setData($context); 
        }

    }

    //Inicia o processo da mensagem
    if (isset($message)) {
        processMessage($message);
    }

?>
