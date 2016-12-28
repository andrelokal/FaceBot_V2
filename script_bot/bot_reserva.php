<?php

    //processa mensagem
    function processMessage($message) {
        
        global $objFace, $objComponent, $objLog, $sender, $text, $objValida;
                
        $context = $objLog->getData();
        
        $context['robo'] = 'reserva'; //Seta a rota escolhida pelo usuario
        
        $arrQuestion = array(
               0=>"Vamos come�ar!", 
               1=>"Voc� estar� acompanhado?", 
               2=>"Em qual loja ou cidade voc� deseja retirar o ve�culo?", 
               3=>"Certo. Deseja devolver o carro na mesma loja?",
               4=>"Quando voc� deseja retirar o ve�culo?\n\nExemplo: (".date("d/m/Y 10:00").") ",
               5=>"Certo. Qual ser� a data de devolu��o?\n\nExemplo: (".date("d/m/Y 10:00").") ",
               6=>"Achamos que esses acess�rios/servi�os ser�o �teis para voc�!",
               7=>"Por favor, informe o seu CPF.",
               8=>"Por favor, informe o seu Email.",
               9=>"{$context['profile']['first_name']}, veja o resumo de sua reserva abaixo:");

        //Verifica��o de inicio.
        if(!isset($context['passo'])){
            $context['passo'] = 0;
            $context['profile'] = $objFace->getData($sender);
            $objLog->setData($context);
            $objFace->sendReply(utf8_encode($arrQuestion[0]),$sender);
            exit;   
        }
  
        //Faz valida��o dos dados recebidos
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
        
        //Salva atualiza��o de contexto
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
