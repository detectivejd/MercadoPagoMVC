<?php
namespace Controller;
use App\Session;
use Lib\Upload;
use Clases\Producto;
class ProductosController extends AppController {
    private $upload;
    public function __construct() {
        parent::__construct();
        $this->upload = new Upload("productos");
    }
    public function isGranted($action) {
        if(Session::get("log_in") != null && Session::get("log_in") == "administrador"){
            array_push($this->permissions,"index", "add", "edit", "delete");            
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
        Session::set('p', isset($_GET['p']) ? $_GET['p'] : 1);
        if(isset($_POST['txtbuscador'])){
            Session::set('b', $this->clean($_POST['txtbuscador']));
        } else {
            Session::set('b', Session::get('b'));
        }
        $params = ["%". Session::get('b')."%"];
        $tabla = (new Producto())->find($params);
        $productos = $this->getPaginator()->paginar($tabla, Session::get('p'));
        $paginador = $this->getPaginator()->getPages();
        $this->redirect("index.php",[
            "productos" => $productos,
            "paginador" => $paginador 
        ]);
    }
    public function add(){
        if(isset($_POST["btnaceptar"])){ 
            $producto = $this->createEntity();
            if($producto->create()){
                Session::set("msg",Session::msgSuccess("Producto Creado"));
                header("Location:index.php?c=productos&a=index");
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("add.php");
    }
    public function edit(){
        Session::set("id",$_GET['id']);
        if(Session::get("id") != null && isset($_POST["btnaceptar"])){ 
            $producto = $this->createEntity();
            if($producto->update()){
                Session::set("msg",Session::msgSuccess("Producto Editado"));
                header("Location:index.php?c=productos&a=index");
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("edit.php",[
            "producto" => (new Producto())->findById([Session::get("id")])
        ]);
    }
    public function delete(){
        Session::set("id",$_GET['id']);
        $producto = (new Producto())->findById([Session::get("id")]);
        if(Session::get("id") != null && isset($_POST["btnsip"])){
            if($producto->delete()){
                Session::set("msg",Session::msgSuccess("Producto Borrado"));
                header("Location:index.php?c=productos&a=index");
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("delete.php",[
            "producto" => $producto
        ]);
    }
    private function createEntity(){
        $producto = new Producto();
        $producto->setId(isset($_POST['hid']) ? $_POST['hid'] : 0);
        $producto->setNombre($_POST['txtnombre']);        
        $producto->setPrecio($_POST['txtprecio']);                
        if(isset($_FILES['fimagen']) and !empty($_FILES['fimagen']['name'])){
            $ruta = $this->upload->uploadImage($_FILES['fimagen']);
            $producto->setImagen($ruta);
        } else {
            if($producto->getId() > 0){
                $ruta = (new Producto())->findById([$producto->getId()])->getImagen();
                $producto->setImagen($ruta);            
            }
        }
        return $producto;
    }
}
