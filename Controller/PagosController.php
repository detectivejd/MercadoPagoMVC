<?php
namespace Controller;
require_once APPLICATION_PATH . DS . "extension/vendor/autoload.php";
require_once APPLICATION_PATH . DS . "correo/vendor/autoload.php";
use App\Session;
use Clases\Usuario;
use MercadoPago;
use PHPMailer\PHPMailer\PHPMailer;
class PagosController extends AppController {
    function __construct() {
        parent::__construct();
    }
    public function isGranted($action) {
        $this->permissions = ["success", "failure","pending"];
        if(Session::get("log_in") != null) {
            array_push($this->permissions,"pay");
            if(Session::get("log_in") == "administrador") {
                array_push($this->permissions,"link", "mail");
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
    public function pay(){
        Session::set("id",$_GET['id']);
        MercadoPago\SDK::setAccessToken('TEST-6451616915373368-042720-2a5cde5a2a4020c3baf46fc94be461db-199806132');
        $usuario = (new Usuario())->findById([Session::get("id")]);
        $items = $this->createItems($usuario);
        $preference = $this->createParameter();
        $preference->items = $items;
        $preference->save();
        header("Location:https://www.mercadopago.com.uy/checkout/v1/payment/redirect/86aa7bb4-3099-42bb-aaa8-93605bef9056/payment-option-form/?source=link&preference-id=".$preference->id);
    }
    public function link(){
        Session::set("id",$_GET['id']);
        Session::set('p', isset($_GET['p']) ? $_GET['p'] : 1);
        $datos = (new Usuario())->getUsuariosSinPagar(Session::get("id"));
        $filas = $this->getPaginator()->paginar($datos, Session::get('p'));
        $paginador = $this->getPaginator()->getPages();
        $this->redirect("link.php",[
            "filas" => $filas,
            "paginador" => $paginador 
        ]);
    }
    public function mail(){
        Session::set("isEmail", true);
        Session::set("cid",$_GET['id']);
        $usuario = (new Usuario())->findById([Session::get("cid")]);
        if($usuario->getCorreo() == ""){
            Session::set("msg",Session::msgDanger("Asegurese de que el usuario seleccionado tenga email para mandar el pago"));
        } else {
            MercadoPago\SDK::setAccessToken('TEST-6451616915373368-042720-2a5cde5a2a4020c3baf46fc94be461db-199806132');
            $items = $this->createItems($usuario);
            $preference = $this->createParameter();
            $preference->items = $items;
            $preference->save();
            $mail = $this->createEmail();
            $mail->AddAddress($usuario->getCorreo(), $usuario->nombreCompleto());
            $body = "";
            $body .= "Hola has realizado las siguientes compras por mercado pago: \n\n";
            foreach($preference->items as $item) {
                $body .= $item->quantity." ".$item->title." por: $". ($item->unit_price * $item->quantity)."\n";
            }
            $body .= "\n";
            $body .= "Puede pagar a través de este link:\n";
            $body .= "https://www.mercadopago.com.uy/checkout/v1/payment/redirect/86aa7bb4-3099-42bb-aaa8-93605bef9056/payment-option-form/?source=link&preference-id=".$preference->id;
            $mail->Body = $body;
            if($mail->Send()) {
                Session::set("msg",Session::msgSuccess("El correo para ".$usuario->getUsername(). " ha sido enviado"));                
            } else {
                Session::set("msg",Session::msgDanger($mail->ErrorInfo));
            }
            header("Location:index.php?c=pagos&a=link&id=".Session::get("id"));
            exit();
        }
    }
    private function createItems($usuario){
        $items = [];
        $historial = $usuario->getChildren("historial");
        foreach($historial as $h){
           $item = new MercadoPago\Item();
           $item->title = $h->getProducto()->getNombre();
           $item->quantity = $h->getCantidad();
           $item->unit_price = $h->getProducto()->getPrecio();
           array_push($items,$item);
        }
        return $items;
    }
    private function updateItems(){
        $id = (Session::get("isEmail")) ? Session::get("cid") : Session::get("id");
        $usuario = (new Usuario())->findById([$id]);
        $historial = $usuario->getChildren("historial");
        foreach($historial as $h){
            $h->setPagado(true);
            $usuario->modChild($h);
        }
        if(Session::get("isEmail")){
            Session::set("isEmail",false);        
        }
    }
    public function success(){
        $this->updateItems();
        Session::set("msg",Session::msgSuccess("Pago Realizado"));
        $this->redirect("success.php");
    }
    
    public function failure(){
        Session::set("msg",Session::msgDanger("Pago Fallido"));
        $this->redirect("failure.php");
    }
    
    public function pending(){
        Session::set("msg",Session::msgInfo("Pago Pendiente"));
        $this->redirect("pending.php");
    }
    
    private function createParameter(){
        $preference = new MercadoPago\Preference();
        $preference->back_urls = [
            "success" => "http://localhost/php/MercadoPagoMVC/index.php?c=pagos&a=success",
            "failure" => "http://localhost/php/MercadoPagoMVC/index.php?c=pagos&a=failure",
            "pending" => "http://localhost/php/MercadoPagoMVC/index.php?c=pagos&a=pending"
        ];
        $preference->auto_return = "approved";
        return $preference;
    }
    private function createEmail(){
        $mail = new PHPMailer();
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;  // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->SMTPAutoTLS = false;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username   = "serverjd21@gmail.com";
        //Introducimos nuestra contraseña de gmail
        $mail->Password   = "j1990d21";
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //Definimos el remitente (dirección y, opcionalmente, nombre)
        $mail->SetFrom('corajejd@gmail.com', 'Juandy Ocampo');
        $mail->Subject = 'Cobrando mediante via e-mail';
        return $mail;
    }
}