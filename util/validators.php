<?

/**
* Arquivo de valida��o de dados
* 
* @param mixed $data
*/

/*
function validarTeste($data){
    return array("success"=>false,"msg"=>"deu ruim!!!");   
}
*/

//Validar CPF
function step7($cpf = null) {

    // Verifica se um n�mero foi informado
    if(empty($cpf)) {
        return array("success"=>false,"msg"=>"cpf n�o informado");
    }

    // Elimina possivel mascara
    $cpf = ereg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    // Verifica se o numero de digitos informados � igual a 11 
    if (strlen($cpf) != 11) {
        return array("success"=>false,"msg"=>"quantidade de caracteres n�o corresponde ao de um cpf valido");
    }
    // Verifica se nenhuma das sequ�ncias invalidas abaixo 
    // foi digitada. Caso afirmativo, retorna falso
    else if ($cpf == '00000000000' || 
    $cpf == '11111111111' || 
    $cpf == '22222222222' || 
    $cpf == '33333333333' || 
    $cpf == '44444444444' || 
    $cpf == '55555555555' || 
    $cpf == '66666666666' || 
    $cpf == '77777777777' || 
    $cpf == '88888888888' || 
    $cpf == '99999999999') {
        return array("success"=>false,"msg"=>"cpf inv�lido");
        // Calcula os digitos verificadores para verificar se o
        // CPF � v�lido
    } else {   

        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return array("success"=>false,"msg"=>"cpf inv�lido");
            }
        }

        return array("success"=>true,"msg"=>"cpf v�lido");
    }
}


//Validar Email
function step8($email) {
    $conta = "^[a-zA-Z0-9\._-]+@";
    $domino = "[a-zA-Z0-9\._-]+.";
    $extensao = "([a-zA-Z]{2,4})$";
    $pattern = $conta.$domino.$extensao;
    
    if (ereg($pattern, $email))
        return array("success"=>true,"msg"=>"email v�lido");
    
    else
        return array("success"=>false,"msg"=>"email inv�lido");
}


?>