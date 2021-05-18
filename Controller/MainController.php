<?php
namespace Controller;
use App\Session;
use Clases\Producto;
use Clases\Usuario;
class MainController extends AppController
{
    function __construct() {
        parent::__construct();
    }
    public function index(){
        Session::set('p', isset($_GET['p']) ? $_GET['p'] : 1);
        $tabla = (new Producto())->find();
        if(Session::get("log_in") != null):
            $cantidad = (new Usuario())->getTotalArticulos(Session::get("log_id"));
        else:
            $cantidad = 0;
        endif;
        Session::set("cantidad",$cantidad);
        $productos = $this->getPaginator()->paginar($tabla, Session::get('p'), 8);
        $paginador = $this->getPaginator()->getPages();
        $this->redirect("index.php",[
            "productos" => $productos,
            "paginador" => $paginador,
        ]);
    }
}