<?php 

include_once '../conexion/conexion.class.php';

class Users {

    public function guardarDatos($datos){
        
        $datos = json_decode($datos);
        
        $username = $datos->username_user;
        $email =    $datos->email_user;
        $password = $datos->password_user;
        
        $link = Conexion::connect();
        
        $stmt = $link->prepare("INSERT INTO users (username, email, password, created_at, updated_at)
                                                VALUES (:username, :email, :password, current_timestamp, current_timestamp)");
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        
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