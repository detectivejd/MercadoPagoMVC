<?php
namespace Clases;
class Historial {
    private $usuario;
    private $producto;
    private $fecha;
    private $cantidad;
    private $pagado;
    function getUsuario() {
        return $this->usuario;
    }
    function getProducto() {
        return $this->producto;
    }
    function getFecha() {
        return $this->fecha;
    }
    function getCantidad() {
        return $this->cantidad;
    }
    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    function setProducto($producto) {
        $this->producto = $producto;
    }
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    public function getPagado() {
        return $this->pagado;
    }
    public function setPagado($pagado): void {
        $this->pagado = $pagado;
    }
    function __construct() { 
        $this->usuario = new Usuario();
        $this->producto = new Producto();
    }
    public function subtotal(){
        return $this->producto->getPrecio() * $this->cantidad;
    }
}