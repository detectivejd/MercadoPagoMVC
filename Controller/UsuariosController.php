<?php
namespace Controller;
use App\Session;
use Clases\Rol;
use Clases\Usuario;
class UsuariosController extends AppController {
    function __construct() {
        parent::__construct();
    }
    public function isGranted($action) {
        $this->permissions = ["login", "add"];
        if(Session::get("log_in") != null) {
            unset($this->permissions[0], $this->permissions[1]);
            array_push($this->permissions, "edit", "logic", "view", "logout");
            if(Session::get("log_in") == "administrador") {
                array_push($this->permissions, "index", "add");
            }            
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
        $params = [ ":filtro" => "%". Session::get('b')."%"];
        $tabla = (new Usuario())->find($params);
        $usuarios = $this->getPaginator()->paginar($tabla, Session::get('p'));
        $paginador = $this->getPaginator()->getPages();
        $this->redirect("index.php", [
            "usuarios" => $usuarios,
            "paginador" => $paginador 
        ]);
    }
    public function login(){        
        if(isset($_POST['btnaceptar'])) {
            if(empty($_POST['txtusername']) || empty($_POST['txtpassword'])){ 
                Session::set("msg", Session::msgDanger("Ingrese los datos obligatorios (*) para continuar."));
            } else {
                $usuario = (new Usuario())->login([$_POST['txtusername'], $_POST['txtpassword']]);
                if ($usuario->getUsername() != "" and $usuario->getPassword() != "") {
                    if($usuario->getTocado()){
                        $usuario->setTocado(false);
                        $usuario->update();
                    }
                    Session::login();
                    Session::set("log_id", $usuario->getId());
                    Session::set("log_in", $usuario->getRol()->getNombre());
                    Session::set("msg", Session::msgInfo("Acceso concedido... Usuario: ". $usuario->getUsername()));
                    header("Location:index.php?c=main&a=index");
                    exit();
                } else {     
                    Session::set("msg",Session::msgDanger("Acceso denegado."));
                }
            }
        }
        $this->redirect("login.php");
    }
    public function logout(){
        Session::set("log_id", 0);
        Session::set("log_in", null);
        Session::set("msg",Session::msgInfo("Acceso finalizado."));
        header("Location:index.php?c=main&a=index");                
    }
    public function add(){        
        $roles = (new Rol())->find();
        if(isset($_POST["btnaceptar"])){ 
            $usuario = $this->createEntity();
            if($usuario->create()){
                $this->redirectAdded();
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("add.php", [
            "roles" => $roles
        ]);
    }
    private function redirectAdded(){
        if(Session::get("log_in")){
            Session::set("msg",Session::msgSuccess("Usuario Creado"));
            header("Location:index.php?c=usuarios&a=index");
        } else {
            Session::set("msg",Session::msgSuccess("Has creado tu cuenta... Puedes iniciar sesion"));
            header("Location:index.php?c=main&a=index");
        }
    }
    public function edit(){
        Session::set("v",$_GET['v']);
        Session::set("id",$_GET['id']);
        $roles = (new Rol())->find();
        if(isset($_POST["btnaceptar"])){
            $usuario = $this->createEntity();
            if($usuario->update()){                
                $this->redirectEdited($usuario->getId());
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("edit.php", [
            "roles" => $roles,
            "usuario" => (new Usuario())->findById([Session::get("id")])

        ]);
    }
    private function redirectEdited($id){
        if(Session::get("log_in")){
            $mensaje = ($id == Session::get('log_id')) ? "Has editado tu cuenta..." : "Usuario Editado";
            Session::set("msg",Session::msgSuccess($mensaje));
            if(Session::get("v") == 1){
                header("Location:index.php?c=usuarios&a=index");
            } else {
                header("Location:index.php?c=usuarios&a=view&id=".$id);
            }
        }
    }
    public function logic(){
        Session::set("v",$_GET['v']);
        Session::set("id",$_GET['id']);
        $usuario = (new Usuario())->findById([Session::get("id")]);
        if(Session::get("id") != null && isset($_POST["btnsip"])){
            $usuario->setTocado($usuario->getTocado() ? false : true);
            if($usuario->update()){
                $this->redirectLogic($usuario);
                exit();
            } else {
                Session::set("msg",Session::msgDanger(Session::get('msg')[2]));
            }
        }
        $this->redirect("logic.php", [
            "usuario" => $usuario
        ]);
    }
    private function redirectLogic($usuario){
        if(Session::get("log_in")){
            $mensaje = "";
            if($usuario->getId() != Session::get('log_id')){
                $mensaje =  "Usuario ";
                $mensaje .= $usuario->getTocado() ? "Desactivado" : "Reactivado";
            } else {
                $mensaje = "Desactivaste tu cuenta... Puedes recuperarla cuando vuelvas a iniciar sesión";                
            }
            Session::set("msg",Session::msgSuccess($mensaje));                
            if($usuario->getId() != Session::get('log_id') && Session::get("v") == 1){
                header("Location:index.php?c=usuarios&a=index");
            } else {
                Session::set("log_id", 0);
                Session::set("log_in", null);
                header("Location:index.php?c=main&a=index");                
            }
        }
    }
    public function view(){
        Session::set("id",$_GET['id']);
        $usuario = (new Usuario())->findById([Session::get("id")]);
        $this->redirect("view.php", [
            "usuario" => $usuario
        ]);
    }
    private function createEntity(){
        $rol = (new Rol())->findBy("name", [$_POST['rol']]);
        $usuario = new Usuario();
        $usuario->setId(isset($_POST['hid']) ? $_POST['hid'] : 0);
        $password = $this->getPassword($usuario->getId(), $_POST['txtpassword']);
        $usuario->setUsername($_POST['txtusername']);
        $usuario->setPassword($password);
        $usuario->setNombre($_POST['txtnombre']);
        $usuario->setApellido($_POST['txtapellido']);
        $usuario->setCorreo($_POST['txtcorreo']);
        $usuario->setCelular($_POST['txtcelular']);
        $usuario->setTocado(false);
        $usuario->setRol($rol);
        return $usuario;
    }
    private function getPassword($id, $password){
        $pass = "";
        if($id > 0){
            if($password != ""){
                $pass = sha1($password);
            } else {
                $usuario = (new Usuario())->findById([$id]);
                $pass = $usuario->getPassword();
            }
        } else {
            $pass = sha1($password);
        }
        return $pass;
    }
}