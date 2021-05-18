<?php
namespace Model;
use Clases\Historial;
class HistorialModel extends AppModelChild {
    private $usuario;
    function __construct($xusuario) {
        parent::__construct();
        $this->usuario = $xusuario;
    }
    protected function getSQLSelect($params = []){
        $query = parent::getSQLSelect();
        if(count($params) > 0){
            $query .= " where user_id = ?";
        }
        return $query;
    }
    //put your code here
    protected function createEntity($row) {
        $modp = new ProductoModel();
        $historial = $this->newInstance();
        $historial->setUsuario($this->usuario);
        $historial->setProducto($modp->findById([$row["prod_id"]]));        
        $historial->setFecha($row["fecha"]);        
        $historial->setCantidad($row["cantidad"]);
        $historial->setPagado($row["pagado"]);
        return $historial;
    }

    protected function getKeyParameters($object) {
        $parameters = [
            "user_id" => $object->getUsuario()->getId(),
            "prod_id" => $object->getProducto()->getId(),
            "fecha" => $object->getFecha()
        ];
        return $parameters;
    }

    protected function getParameters($object) {
        $parameters = [
            "cantidad" => $object->getCantidad(),
            "pagado" => $object->getPagado()
        ];
        return $parameters;
    }
    protected function getSQLDeleteMessage($object) {
        return "";
    }
    protected function getSQLUniqueKeyMessage($object) {
        return "";
    }
    protected function getSQLUniqueKeyParameters($object) {
       return $this->getKeyParameters($object);
    }
    protected function getTable() {
        return "historial";
    }
    protected function newInstance() {
        return new Historial();
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