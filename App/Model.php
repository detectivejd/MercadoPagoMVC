<?php
namespace App;
use \App\Session;
abstract class Model implements IModel {
    protected $db;
    private $isChild;
    function __construct($flag) {
        $this->isChild = $flag;
        $this->db = new Database();
    }
    public function aggregateFunction($query, $parameters = []){
        return $this->db->findAggregate($query, $parameters);
    }
    /*------------------------------------------------------------------------*/
    private function validateUniqueKey($object) {
        $query = $this->getSQLUniqueKey($object);
        $params = array_values($this->getSQLUniqueKeyParameters($object));
        return $this->db->execute($query, $params);
    }
    /*------------------------------------------------------------------------*/
    public function create($object) {
        $mensaje = $this->getSQLUniqueKeyMessage($object);
        if($mensaje != ""){
            if($this->validateUniqueKey($object)){
                Session::set('msg', Session::msgDanger($mensaje));
                return null;
            }        
        }
        $query = $this->getSQLInsert($object);
        $params = $this->getSQLInsertParameters($object);
        return $this->db->execute($query, $params);        
    }
    /*------------------------------------------------------------------------*/    
    public function update($object) {
        $values = array_values($this->getKeyParameters($object));
        $row = $this->findById($values);
        $mensaje = $this->getSQLUniqueKeyMessage($object);
        if($mensaje != ""){
            if(!$object->equals($row)){
                if($this->validateUniqueKey($object)){
                    Session::set('msg', Session::msgDanger($mensaje));
                    return null;
                }
            }        
        }
        $query = $this->getSQLUpdate($object);
        $params = $this->getSQLUpdateParameters($object);
        return $this->db->execute($query, $params);
    }
    /*------------------------------------------------------------------------*/
    public function delete($object) {
        $mensaje = $this->getSQLDeleteMessage($object);
        if($mensaje != ""){
            Session::set('msg', Session::msgDanger($mensaje));
            return null;
        }      
        $query = $this->getSQLDelete($object);
        $params = $this->getSQLDeleteParameter($object);
        return $this->db->execute($query, $params);
    }

    /*--------------------------------------------------------------------*/
    public function find($params = []) {
        $datos = [];
        $query = $this->getSQLSelect($params);
        $table = $this->db->findAll($query, $params);
        foreach($table as $row){
            $obj = $this->createEntity($row);
            array_push($datos, $obj);
        }
        return $datos;
    }
    /*--------------------------------------------------------------------*/
    function findBy($field, $params = []){
        $query = $this->getSQLFindBy($field);
        $res = $this->db->findBy($query, $params);
        return $this->createEntity($res);
    }
    /*--------------------------------------------------------------------*/
    public function findById($params = []) {
        $query = $this->getSQLFindById();
        $res = $this->db->findBy($query, $params);
        return $this->createEntity($res);
    }
    /*--------------------------------------------------------------------*/
    protected function getSQLInsert($object){
        $cant = 0;
        $query = "insert into ". $this->getTable() ."(";
        $fields = array_keys($this->getParameters($object));
        $endf = end($fields);
        if($this->isChild){
            $keys = array_keys($this->getKeyParameters($object));
            $endk = end($keys);
            foreach($keys as $key){
                $query .= $key;
                $query .= ($key != $endk) ? "," : "";
            }
            if(count($fields) > 0){
                $query .= ",";
            }
            $cant = count($keys);
        }
        
        foreach($fields as $field){
            $query .= $field;
            $query .= ($field != $endf) ? "," : "";
        }
        $cant += count($fields);
        $query .= ") values(";
        for($i = 0; $i < $cant; $i++){
            $query .= "?";
            $query .= ($i != ($cant -1)) ? "," : "";
        }
        $query .= ")";
        return $query;
    }
    protected function getSQLInsertParameters($object){
        $data = [];
        $fields = array_values($this->getParameters($object));
        if($this->isChild){
            $keys = array_values($this->getKeyParameters($object));
            foreach($keys as $key){
                array_push($data, $key);
            }
        }
        foreach($fields as $field){
            array_push($data, $field);
        }
        return $data;
    }
    protected function getSQLUpdate($object){
        $query = "update ".$this->getTable()." set ";
        $fields = array_keys($this->getParameters($object));
        $endf = end($fields);
        $keys = array_keys($this->getKeyParameters($object));
        $endk = end($keys);
        foreach($fields as $field){
            $query .= $field." = ? ";
            if($field != $endf){
                $query .= ($field != end($fields)) ?", " : " ";                
            }
        }
        $query .= "where ";
        foreach($keys as $key){
            $query .= $key." = ?";
            if($key != $endk){
                $query .= " and ";
            }
        }
        return $query;
    }
    protected function getSQLUpdateParameters($object){
        $data = [];
        $fields = array_values($this->getParameters($object));
        $keys = array_values($this->getKeyParameters($object));
        foreach($fields as $field){
            array_push($data, $field);
        }
        foreach($keys as $key){
            array_push($data, $key);
        }
        
        return $data;
    }
    private function getSQLDelete($object){
        $query = "delete from ".$this->getTable();
        echo $query;
        $query .= " where ";
        $keys = array_keys($this->getKeyParameters($object));
        $end = end($keys);        
        foreach($keys as $key){
            $query .= $key." = ?";
            if($key != $end){
                $query .= " and ";
            }
        }
        return $query;
    }
    private function getSQLDeleteParameter($object){
        $data = [];
        $keys = array_values($this->getKeyParameters($object));
        foreach($keys as $key){
            array_push($data, $key);
        }
        return $data;
    }    
    private function getSQLUniqueKey($object){
        $query = "select * from ".$this->getTable();
        $query .= " where ";
        $keys = array_keys($this->getSQLUniqueKeyParameters($object));
        $end = end($keys);
        foreach($keys as $key){
            $query .= $key ." = ?";
            if($end != $key){
                $query .= " and ";
            }
        }
        return $query;
    }
    private function getSQLFindById(){        
        $object = $this->newInstance();
        $query = "select * from ".$this->getTable();        
        $query .= " where ";
        $keys = array_keys($this->getKeyParameters($object));
        $end = end($keys);
        foreach($keys as $key){
            $query .= $key." = ?";
            if($key != $end){
                $query .= " and ";
            }
        }        
        return $query;
    }
    protected function getSQLSelect($params = []){
        $query = "select ".$this->getSQLSelectFields()." from ".$this->getTable();
        return $query;
    }
    protected function getSQLSelectFields(){
        return "*";
    }
    protected function getSQLFindBy($field){
        $query = "select * from ".$this->getTable()." where ".$field." = ?";
        return $query;
    }
    /*--------------------------------------------------------------------*/
    public function addChild($object, $child){
        return $this->getAddChild($object, $child);
    }
    public function modChild($object, $child){
        return $this->getModChild($object, $child);
    }
    public function delChild($object, $child){
        return $this->getDelChild($object, $child);
    }
    public function getChild($hijo, $params = []) {
        return $this->getInnerChild($hijo, $params);
    }    
    public function getChildren($hijo, $object) {
        return $this->getInnerChildren($hijo, $object);
    }
    /*--------------------------------------------------------------------*/
    abstract protected function getSQLUniqueKeyParameters($object);
    abstract protected function getSQLUniqueKeyMessage($object);
    abstract protected function getSQLDeleteMessage($object);
    abstract protected function getParameters($object);
    abstract protected function getKeyParameters($object);
    abstract protected function getAddChild($object, $child);
    abstract protected function getModChild($object, $child);
    abstract protected function getDelChild($object, $child);
    abstract protected function getInnerChild($hijo, $params = []);
    abstract protected function getInnerChildren($hijo, $object);
    abstract protected function getTable();
    abstract protected function createEntity($row);
    abstract protected function newInstance();
}