<?php
namespace Model;
use Clases\Producto;
class ProductoModel extends AppModelEntity {
    public function __construct() {
        parent::__construct();
    }    
    protected function getSQLSelect($params = []){
        $query = parent::getSQLSelect();
        if(count($params) > 0){
            $query .= " where name like ?";
        }
        return $query;
    }    
    protected function getParameters($object) {
        $parameters = [
            "name" => $object->getNombre(),
            "precio" => $object->getPrecio(),
            "imagen" => $object->getImagen()
        ];
        return $parameters;
    }
    protected function getKeyParameters($object) {
        $parameters = [
            "id" => $object->getId()
        ];
        return $parameters;
    }
    protected function getTable() {
        return "productos";
    }    
    protected function createEntity($row) {
        $producto = $this->newInstance();
        $producto->setId($row["id"]);
        $producto->setNombre($row["name"]);
        $producto->setPrecio($row["precio"]);
        $producto->setImagen($row["imagen"]);        
        return $producto;
    }
    protected function getSQLUniqueKeyParameters($object) {
        $parameters = [
            "name" => $object->getNombre()
        ];
        return $parameters;
    }
    protected function getSQLUniqueKeyMessage($object) {
        return "El producto: ".$object->getNombre()." ya existe";
    }
    protected function getSQLDeleteMessage($object) {
        $mensaje = "";
        $cantidad = $this->aggregateFunction("select count(*) from temporalproducts where idproduct = ?", 
            [$object->getId()]);
        if($cantidad > 0){
            $mensaje .= "Hay ".$cantidad;
            $mensaje .= ($cantidad == 1) ? " registro" : " registros";
            $mensaje .= " del producto: ".$object->getNombre().", en el historial.";
        }
        return $mensaje;
    }    
    protected function newInstance() {
        return new Producto();
    }
    protected function getAddChild($object, $child) {
        return null;
    }
    protected function getModChild($object, $child) {
        return null;
    }
    protected function getDelChild($object, $child) {
        return null;
    }
    protected function getInnerChild($hijo, $params = []){
        return null;
    }
    public function getInnerChildren($hijo, $object) {
        return null;
    }
}