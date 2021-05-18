<?php
namespace Clases;
use \App\IPersiste;
use \Model\ProductoModel;
class Producto implements IPersiste {
    private $id;
    private $nombre;
    private $precio;
    private $imagen;
    private $model;
    function getId() {
        return $this->id;
    }
    function getNombre() {
        return $this->nombre;
    }
    function getPrecio() {
        return $this->precio;
    }
    function getImagen() {
        return $this->imagen;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    function setPrecio($precio) {
        $this->precio = $precio;
    }
    function setImagen($imagen) {
        $this->imagen = $imagen;
    }
    function __construct() {
        $this->model = new ProductoModel();
    }        
    public function equals($object){
        if($object instanceof Producto){
            return $this->nombre === $object->getNombre();
        } else {
            return false;
        }
    }
    public function create() {
        return $this->model->create($this); 
    }
    public function update() {
        return $this->model->update($this); 
    }
    public function delete() {
        return $this->model->delete($this); 
    }
    public function find($params = []) {
        return $this->model->find($params);
    }
    public function findById($params = []) {
        return $this->model->findById($params);
    }
    public function findBy($field, $params = []) {
        return $this->model->findBy($field,$params);
    }
    public function addChild($object) {
        return $this->model->addChild($this, $object);
    }
    public function modChild($object) {
        return $this->model->modChild($this, $object);
    }
    public function delChild($object) {
        return $this->model->delChild($this, $object);
    }
    public function getChild($hijo, $params = []){
        return $this->model->getChild($hijo, $params);
    }
    public function getChildren($hijo) {
        return $this->model->getChildren($hijo, $this);
    }    
}