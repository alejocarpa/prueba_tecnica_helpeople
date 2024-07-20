<?php 

include_once '../conexion/conexion.class.php';

class Cart {
    
    public function buscarDatos($datos){     
        
        $link = Conexion::connect();
        
        $query = "SELECT *
                    FROM cart";
        
        $stmt = $link->prepare($query);
        
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);
        
        $link = null;
        
        return $resultado;
    }
    
    public function guardarDatos($datos){
        
        $datos = json_decode($datos);
        
        $product =  $datos->product;     
        $quantity = $datos->quantity;
        
        $link = Conexion::connect();
        
        $stmt = $link->prepare("INSERT INTO cart (product_id, quantity, created_at) 
                                                VALUES (:product, :quantity, current_timestamp)");
        
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':quantity', $quantity);
        
        // Excecute
        $stmt->execute();
        
        $arr_error = $stmt->errorInfo();
        
        $id = $link->lastInsertId();
        
        $link = null;
        
        if(!$arr_error[2]){
            return array("lastId" => $id);
        }else{
            return array("error" => $arr_error[2]);
        }
    }
    
}
?>