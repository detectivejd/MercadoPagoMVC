<?php
namespace App;
use Lib\Paginador;
include('./Lib/fpdf/FPDF.php');
abstract class Controller {
    private $paginador;
    private $pdf;
    protected $permissions;
    function __construct() {
        session_start();
        $this->permissions = [];
        $this->paginador = new Paginador();
        $this->pdf = new \FPDF();
    }
    public function redirect($file, $dates = array()) {
        try {
            $ns = explode('\\', get_called_class());
            $path = $this->createFile(APPLICATION_PATH . DS . "View" . DS . str_replace("Controller", "", $ns[1]) . DS . $file, $dates);
            $menu = $this->createFile(APPLICATION_PATH . DS . 'Public' . DS . 'menu.php');
            echo $this->createFile(APPLICATION_PATH . DS . 'Public' . DS . 'layout.php', array('content' => $path, 'menu' => $menu));
        } 
        catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    private function createFile($file, $dates = array()) {
        try {
            extract($dates);
            ob_start();
            require $file;
            return ob_get_clean();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    protected function getPaginator() {
        return $this->paginador;
    }
    protected function getPdf() {
        return $this->pdf;
    }
    protected function clean($cadena){
        return htmlentities($cadena);
    }
    protected function invoke($action) {
        if (method_exists($this, $action)){
            $this->$action();
        }
    }
    protected function getMessageRole() { }
    protected function getTypeRole() { }
    public function isGranted($action) { 
        $this->invoke($action);
    }
    
}