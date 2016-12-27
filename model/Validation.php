<?php
/**
* Validation
* VALIDAÇÕES DE DADOS
* @author      André Martos
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
    * Se não encontrar o arquivo retorna false
    * Se não encontrar a função retorna true
    * @param mixed $dados (dados para validação)
    * @param mixed $funcao (nome da função que irá validar)
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
