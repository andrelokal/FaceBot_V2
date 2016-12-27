<?
class ArqLog{
    
    public $content = "";
    public $fileName = "";
    
    public function __construct($idUser){
        
        $this->fileName = $idUser.".log";
        
        if(file_exists($this->fileName)){
            $this->content = file_get_contents($this->fileName);    
        }else{
            file_put_contents($this->fileName,"");    
        }        
    }
    
    public function setData($data = array()){
        $data = json_encode($data);
        file_put_contents($this->fileName,$data);
        $this->content = file_get_contents($this->fileName);    
    }
    
    public function getData(){
        return json_decode($this->content,true);    
    }
}
?>