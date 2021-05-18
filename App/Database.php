<?php
namespace App;
use \PDO;
final class Database {  
    private $bd;  
    private $dns;
    private $user;
    private $pass;
    public function __construct() { 
        $this->dns='mysql:dbname=carritocompra2;host=localhost';
        $this->user='root';
        $this->pass='j1990d21';
        if (!isset($this->bd)) {  
            $this->bd = new PDO($this->dns, $this->user, $this->pass);  
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        }
    }
    public function getConnect() {            
        return $this->bd;  
    }
    
    public function execute($query, $parameters = []){
        $consulta = $this->bd->prepare($query);
        $this->doParam($consulta, $parameters);        
        $consulta->execute();  
        return $consulta->rowCount() > 0;
    }
    public function findBy($query, $parameters = []) {
        $consulta = $this->bd->prepare($query);
        $this->doParam($consulta, $parameters);
        $consulta->execute();
        if($consulta->rowCount() > 0) {
            $res = $consulta->fetchAll(PDO::FETCH_ASSOC)[0];
            return $res; 
        } else {
            return null;
        }
    }
    public function findAggregate($query, $parameters = []){
        $consulta = $this->bd->prepare($query);
        $this->doParam($consulta, $parameters);
        $consulta->execute();
        $agg = (int) $consulta->fetchColumn();
        return $agg;
    }
    public function findAll($query, $parameters = []){
        $consulta = $this->bd->prepare($query);
        $this->doParam($consulta, $parameters);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    private function doParam($consulta, $parameters = []){
        if($this->is_assoc($parameters)){
            foreach($parameters as $key => $value){                
                $consulta->bindParam($key, $value);
            }
        } else {
            $cant = count($parameters);        
            for($i = 1; $i <= $cant; $i++){
                $consulta->bindParam($i, $parameters[$i - 1]);
            }        
        }
    }
    private function is_assoc($var){
        return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
    }
}  
?>  