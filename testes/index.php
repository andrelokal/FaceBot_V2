<?php
   
    //INCLUDES
    require_once ('FacebookHelper.php');
    

    $objFace = new FacebookHelper();
    
    
    echo $objFace->getAuthentication($_REQUEST);
    

    
    function processMessage($message) {
        
        $array = array(0=>"Guarapari Buzios � Minha Arte", 
					   1=>"O meu pai ?", 
					   2=>"Romero Brito?", 
					   3=>"Voc� ta quebrando o meu bra�o!",
					   4=>"Vo da o c� e sair cagando!!!",
					   5=>"Felipe... Smith",
					   6=>"16... 18",
					   7=>"Samu?.... Seu C�",
					   8=>"� Obvio Velho",
					   9=>"Katrina?",
					   10=>"Adriano?",
					   11=>"� obvio gente vai doer pra caralho!!",
					   12=>"Faz isso comigo n�o Velho",
					   13=>"Mata o papai!!!",
					   14=>"Se eu to chamando?",
					   15=>"Rave?",
					   16=>"Seu C�",
					   17=>"Red Room?",
					   18=>"Eu n�o sei nem onde eu to Vei",
					   19=>"5KM?",
					   20=>"Jamais ser�! acende um incenso pra mim pelo amor de Deus");
		
		$array2 = array(0=>"obrigado!!!",
						1=>"valeu",
						2=>"faz isso comigo n�o vei",
						3=>"� obvio vei",
						4=>"obrigado :)",
						5=>"Seu c�!!");
						
		$array3 = array(0=>"baixa o nivel n�o vei... assim vc mata o papai",
				1=>"fala isso comigo n�o vei",
				2=>"Seu c�");
        
        
        
        $objFaceF = new FacebookHelper();
        $sender = $message['sender']['id'];
        $text = $message['message']['text'];
        if (isset($text)) {
            if(preg_match('[onde|lugar|local]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[18]))));
            }elseif(preg_match('[nome|chama]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[5]))));    
            }elseif(preg_match('[samu]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[7]))));    
            }elseif(preg_match('[idade|anos]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[6]))));    
            }elseif(preg_match('[pai]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[1]))));    
            }elseif(preg_match('[homero|romero|brito]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[2]))));    
            }elseif(preg_match('[smith|smit]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[16]))));    
            }elseif(preg_match('[corinthians|campe�o|campeao|vitoria]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[20]))));    
            }elseif(preg_match('[catrina|katrina|furac�o|furacao]', strtolower($text))) {
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[9]))));    
            }elseif(preg_match('[burro|idiota|imbecil|babaca|otario|bob�o|viado|bixinha|homossexual|vagabundo|pilantra|retardado|puto|boiola|puta|frutinha|bobao|bixa|baitola|fresco|gay|troxa|trouxa|bichona|bixona|cuz�o|cuzao]', strtolower($text))) {
                $rand = rand ( 0 , 5 );
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array2[$rand]))));    
            }elseif(preg_match('[fodasse|caralho|porra|buceta|piroca|merda|bosta|lixo|rola|pinto]', strtolower($text))) {
                $rand = rand ( 0 , 2 );
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array3[$rand]))));    
            }
            else {
                $rand = rand ( 0 , 20 );
                $objFaceF->sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => utf8_encode($array[$rand]))));
            }
            
        } 
    }

    
    $update_response = file_get_contents("php://input");
    $update = json_decode($update_response, true);
    if (isset($update['entry'][0]['messaging'][0])) {
        processMessage($update['entry'][0]['messaging'][0]);
    }
    
    


?>
