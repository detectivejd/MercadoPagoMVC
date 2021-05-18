<?php
namespace Model;
use Clases\Usuario;
use Clases\Historial;
class UsuarioModel extends AppModelEntity {
    public function __construct() {
        parent::__construct();
    }
    protected function getSQLSelectFields(){
        $fields = "u.id as id, u.username as username, u.password as password,";
        $fields .= "u.firstname as firstname, u.lastname as lastname,";
        $fields .= "u.email as email, u.cellphone as cellphone,";
        $fields .= "u.touched as touched, u.rol_id as rol_id";
        return $fields;
    }
    protected function getSQLSelect($params = []){
        $query = parent::getSQLSelect();
        if(count($params) > 0){
            $query .= " u";
            $query .= " inner join roles r on u.rol_id = r.id";
            $query .= " where u.username like :filtro";
            $query .= " or u.firstname like :filtro";
            $query .= " or r.name like :filtro";
        }
        return $query;
    } 
    protected function createEntity($row) {
        $mr = new RolModel();
        $usuario = $this->newInstance();
        $usuario->setId($row["id"]);
        $usuario->setUsername($row["username"]);
        $usuario->setPassword($row["password"]);
        $usuario->setNombre($row["firstname"]);
        $usuario->setApellido($row["lastname"]);
        $usuario->setCorreo($row["email"]);
        $usuario->setCelular($row["cellphone"]);
        $usuario->setTocado($row["touched"]);
        $usuario->setRol($mr->findById([$row["rol_id"]]));
        return $usuario;
    }
    protected function getParameters($object) {
        $parameters = [
            "username" => $object->getUsername(),
            "password" => $object->getPassword(),
            "firstname" => $object->getNombre(),
            "lastname" => $object->getApellido(),
            "email" => $object->getCorreo(),
            "cellphone" => $object->getCelular(),
            "touched" => $object->getTocado()            
        ];
        if($object->getRol() != null){
            $parameters["rol_id"] = $object->getRol()->getId();
        }
        return $parameters;
    }
    protected function getSQLDeleteMessage($object) {
        return "";
    }
    protected function getSQLUniqueKeyMessage($object) {
        return "El usuario: ".$object->getUsername()." ya existe";
    }
    protected function getSQLUniqueKeyParameters($object) {
        $parameters = [
            "username" => $object->getUsername()
        ];
        return $parameters;
    }
    protected function getTable() {
        return "usuarios";
    }
    protected function newInstance() {
        return new Usuario();
    }
    /*-------------------------------------------*/
    public function login($datos = []){
        $query = $this->getLoginQuery();
        $params = $this->getLoginParameter($datos);
        $res = $this->db->findBy($query, $params);
        return $this->createEntity($res);
    }
    private function getLoginQuery(){
        return "select * from usuarios where username = ? and password = ?";
    }
    private function getLoginParameter($datos = []){
        return [
            $datos[0], 
            sha1($datos[1])
        ];
    }    
    /*-------------------------------------------*/
    public function getTotalArticulos($id){
        $cantidad = $this->aggregateFunction("SELECT SUM(cantidad) FROM historial WHERE user_id= ? and pagado = ?", 
            [$id, false]);
        return $cantidad;
    }
    /*-------------------------------------------*/
    public function getUsuariosSinPagar($id){
        $datos = [];
        $rows = $this->db->findAll("SELECT u.id, u.username, sum(h.cantidad) as cantidad 
            FROM historial h INNER JOIN usuarios u on h.user_id = u.id 
            WHERE not u.id = ? and h.pagado = ? GROUP BY u.username;", [$id, false]);
        foreach($rows as $row){
            array_push($datos,$row);
        }
        return $datos;
    }
    /*-------------------------------------------*/
    protected function getKeyParameters($object) {
        $parameters = [
            "id" => $object->getId()
        ];
        return $parameters;
    }
    protected function getAddChild($object, $child) {
        if($child instanceof Historial){
            $mod = new HistorialModel($object);
            return $mod->create($child);
        } else {
            return null;
        }
    }
    protected function getModChild($object, $child) {
        if($child instanceof Historial){
            $mod = new HistorialModel($object);
            return $mod->update($child);
        } else {
            return null;
        }
    }
    protected function getDelChild($object, $child) {
        if($child instanceof Historial){
            $mod = new HistorialModel($object);
            return $mod->delete($child);
        } else {
            return null;
        }
    }
    protected function getInnerChild($hijo, $params = []){
        if($hijo === "historial"){            
            $usuario = $this->findById([$params[0]]);
            $mod = new HistorialModel($usuario);
            return $mod->findById($params);
        } else {
            return null;
        }
    }
    public function getInnerChildren($hijo, $object) {
        if($hijo === "historial"){            
            $mod = new HistorialModel($object);
            return $mod->find([$object->getId()]);
        } else {
            return null;
        }
    }
}
