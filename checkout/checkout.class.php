<?php 

include_once '../conexion/conexion.class.php';

class Checkout {

    public function guardarDatos($datos){
        
        $datos = json_decode($datos);
        
        $message = "";
        
        $total = $datos->total_cart;
        $credit = $datos->total_credit;
        
        $newCredit = $credit - $total;
        
        $link = Conexion::connect();
        
        $stmt = $link->prepare("TRUNCATE cart");        
        
        // Excecute
        $stmt->execute();
        
        $arr_error = $stmt->errorInfo();
        
        $link = null;
        
        if(!$arr_error[2]){
            if( $newCredit >= 0 ){
                return array(
                    "message" => "La compra fue realizada con exito",
                    "newCredit" => $newCredit,
                    "ok" => true
                );
            }elseif ( $newCredit < 0 ){
                return array(
                    "message" => "La compra no fue posible",
                    "newCredit" => $credit,
                    "ok" => false
                );
            }
            
        }else{
            return array("error" => $arr_error[2]);
        }
    }
    
}
?>