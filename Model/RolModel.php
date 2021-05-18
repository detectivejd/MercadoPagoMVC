<?php
namespace Model;
use Clases\Rol;
class RolModel extends AppModelEntity {
    public function __construct() {
        parent::__construct();
    }
    protected function createEntity($row) {
        $rol = $this->newInstance();
        $rol->setId($row["id"]);
        $rol->setNombre($row["name"]);
        return $rol;
    }
    protected function getParameters($object) {
        $parameters = [
            "name" => $object->getNombre()
        ];
        return $parameters;
    }
    protected function getKeyParameters($object) {
        $parameters = [
            "id" => $object->getId()
        ];
        return $parameters;
    }
    protected function getSQLDeleteMessage($object) {
        $mensaje = "";
        $cantidad = $this->aggregateFunction("select count(*) from usuarios where rol_id = ?", 
            [$object->getId()]);
        if($cantidad > 0){
            $mensaje .= "Hay ".$cantidad;
            $mensaje .= ($cantidad == 1) ? " usuario" : " usuarios";
            $mensaje .= " usando el rol: ".$object->getNombre().".";
        }
        return $mensaje;
    }
    protected function getSQLUniqueKeyMessage($object) {
        return "El rol: ".$object->getNombre()." ya existe";
    }
    protected function getSQLUniqueKeyParameters($object) {
        $parameters = [
            "name" => $object->getNombre()
        ];
        return $parameters;
    }
    protected function getTable() {
        return "roles";
    }
    protected function newInstance() {
        return new Rol();
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