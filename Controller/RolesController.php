<?php
namespace Controller;
use App\Session;
use Clases\Rol;
class RolesController extends AppController {
    function __construct() {
        parent::__construct();
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
        $roles = (new Rol())->find(); 
        $this->redirect("index.php",[
            "roles" => $roles
        ]);
    }
    public function add(){
        if(isset($_POST["btnaceptar"])){ 
            $rol = $this->createEntity();
            if($rol->create()){
                Session::set("msg",Session::msgSuccess("Rol Creado"));
                header("Location:index.php?c=roles&a=index");
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
            $rol = $this->createEntity();
            if($rol->update()){
                Session::set("msg",Session::msgSuccess("Rol Editado"));
                header("Location:index.php?c=roles&a=index");
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("edit.php",[
            "rol" => (new Rol())->findById([Session::get("id")])
        ]);
    }
    public function delete(){
        Session::set("id",$_GET['id']);
        $rol = (new Rol())->findById([Session::get("id")]);
        if(Session::get("id") != null && isset($_POST["btnsip"])){
            if($rol->delete()){
                Session::set("msg",Session::msgSuccess("Rol Borrado"));
                header("Location:index.php?c=roles&a=index");
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("delete.php",[
            "rol" => $rol
        ]);
    }
    private function createEntity(){
        $rol = new Rol();
        $rol->setId(isset($_POST['hid']) ? $_POST['hid'] : 0);
        $this->setNombre($rol, $_POST['txtnombre']);
        return $rol;
    }
}
