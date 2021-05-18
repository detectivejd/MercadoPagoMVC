<?php
namespace Clases;
use App\IPersiste;
use Model\UsuarioModel;
class Usuario implements IPersiste {
    private $id;
    private $username = "";
    private $password = "";
    private $nombre = "";
    private $apellido = "";
    private $correo = "";
    private $celular = "";
    private $tocado;
    private $rol;
    private $model;
    function getId() {
        return $this->id;
    }
    function getUsername() {
        return $this->username;
    }
    function getPassword() {
        return $this->password;
    }
    function getNombre() {
        return $this->nombre;
    }
    function getApellido() {
        return $this->apellido;
    }
    function getCorreo() {
        return $this->correo;
    }
    function getCelular() {
        return $this->celular;
    }
    function getTocado() {
        return $this->tocado;
    }
    function getRol() {
        return $this->rol;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setUsername($username) {
        $this->username = $username;
    }
    function setPassword($password) {
        $this->password = $password;
    }
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    function setCorreo($correo) {
        $this->correo = $correo;
    }
    function setCelular($celular) {
        $this->celular = $celular;
    }
    function setTocado($tocado) {
        $this->tocado = $tocado;
    }
    function setRol($rol) {
        $this->rol = $rol;
    }
    function __construct() {
        $this->model = new UsuarioModel();
    }
    public function equals($object){
        if($object instanceof Usuario){
            return $this->username === $object->getUsername();
        } else {
            return false;
        }
    }
    public function nombreCompleto() {
        return $this->nombre." ".$this->apellido;
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
    public function login($datos = []){       
        return $this->model->login($datos);
    }
    public function getTotalArticulos($id){
        return $this->model->getTotalArticulos($id);
    }
    public function getUsuariosSinPagar($id){
        return $this->model->getUsuariosSinPagar($id);
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