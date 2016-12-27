<?php
/**
* Validation
* VALIDA��ES DE DADOS
* @author      Andr� Martos
* @version     1.0
* @date        27/12/2016
*/
class Validation{
    
    public $pathValidator = "";
    public $msg = "";

    /**
    * caminho do arquivo validador
    * @param mixed $pathValidator caminho do arquivo validador
    */
    public function __construct($pathValidator){
        
        $this->pathValidator = $pathValidator;
        
    }  

    /**
    * O arquivo validador sempre deve retornar um array com o success (true/false) e o msg(com a mensagem de erro)
    * Se n�o encontrar o arquivo retorna false
    * Se n�o encontrar a fun��o retorna true
    * @param mixed $dados (dados para valida��o)
    * @param mixed $funcao (nome da fun��o que ir� validar)
    * @return true/false
    */
    public function validarDados($dados,$funcao){

        if(file_exists($this->pathValidator)){
            
            include_once($this->pathValidator);
            
            if(function_exists($funcao)){

                $result = $funcao($dados);
                if(is_array($result)){
                    $this->msg = $result["msg"]; 
                    return $result["success"];
                }else{
                    $this->msg = "tipo de retorno do validador inesperado";
                    return false;
                }     
            }else{
                return true;    
            }

        }else{
            $this->msg = "nao encontrei o arquivo validador";
            return false;
        
        }
            
    }
    
    
    
    
    
}
?>
