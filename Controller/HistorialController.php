<?php
namespace Controller;
use App\Session;
use Clases\Usuario;
use Clases\Producto;
use Clases\Historial;
class HistorialController extends AppController {
    function __construct() {
        parent::__construct();
    }    
    public function isGranted($action) {
        if(Session::get("log_in") != null) {
            array_push($this->permissions,"index","add","delete");
        }
        if(in_array($action, $this->permissions)){
            $this->invoke($action);            
        } else {
            Session::set("msg",Session::msgDanger("No cuentas con los permisos necesarios para acceder al sistema"));
            header("Location:index.php?c=main&a=index");
            exit();
        }
    }
    public function index(){
        Session::set("id",$_GET['id']);
        $usuario = (new Usuario())->findById([Session::get("id")]);        
        $historial = $usuario->getChildren("historial");
        $this->redirect("index.php",[
            "usuario" => $usuario,
            "historial" => $historial
        ]);
    }
    public function add(){
        Session::set("idp",$_GET['idp']);
        $usuario = (new Usuario())->findById([Session::get("log_id")]);
        $producto = (new Producto())->findById([Session::get("idp")]);
        $historial = $this->createEntity($usuario, $producto);
        if($usuario->addChild($historial)){
            Session::set("msg",Session::msgSuccess("El producto: ". $producto->getNombre()." fue agregado al historial"));
            header("Location:index.php?c=main&a=index");
            exit();
        } else {
            Session::set("msg",Session::msgDanger("No se pudo agregar el producto seleccionado al historial"));
        }
    }    
    public function delete(){
        Session::set("idu",$_GET['idu']);
        Session::set("idp",$_GET['idp']);
        Session::set("fecha",$_GET['fecha']);
        $usuario = (new Usuario())->findById([Session::get("idu")]);
        $producto = (new Producto())->findById([Session::get("idp")]);
        $historial = $usuario->getChild("historial",[
            $usuario->getId(),
            $producto->getId(),
            Session::get("fecha")
        ]);
        if($historial != null){
            if($usuario->delChild($historial)) {
                Session::set("msg",Session::msgSuccess("El producto: ". $producto->getNombre()." fue eliminado del historial"));
                $this->cantidadDelCarrito();
                header("Location:index.php?c=historial&a=index&id=".$usuario->getId());
                exit();
            } else {
                Session::set("msg",Session::msgDanger("No se pudo eliminar el producto seleccionado"));
            }
        }
    }
    private function cantidadDelCarrito(){
        if(Session::get("log_in") != null):
            $cantidad = (new Usuario())->getTotalArticulos(Session::get("log_id"));
        else:
            $cantidad = 0;
        endif;
        Session::set("cantidad",$cantidad);
    }
    private function createEntity($usuario,$producto){
        $historial = new Historial();
        $historial->setUsuario($usuario);
        $historial->setProducto($producto);
        $historial->setFecha(date("Y-m-d H:m:s"));
        $historial->setCantidad($_POST["txtcantidad"]);
        $historial->setPagado(false);
        return $historial;
    }
}
