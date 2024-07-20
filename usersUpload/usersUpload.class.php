<?php 

include_once '../conexion/conexion.class.php';

class UsersUpload {

    public function guardarDatos($datos){
        
        $link = Conexion::connect();
        
        $fp = fopen ($_FILES["file"]["tmp_name"],"r");
        
        while ($data = fgetcsv ($fp, 1000, ",")) {
            
            $stmt = $link->prepare("INSERT INTO users (username, email, password, created_at, updated_at)
                                                VALUES (:username, :email, :password, current_timestamp, current_timestamp)");
            
            $stmt->bindParam(':username', $data[0]);
            $stmt->bindParam(':email', $data[1]);
            $stmt->bindParam(':password', $data[2]);
            
            $stmt->execute();
        }
        
        fclose ($fp);
        
        $arr_error = $stmt->errorInfo();
        
        
        $link = null;
        
        if(!$arr_error[2]){
            return array("message" => "Finalizo la carga");
        }else{
            return array("error" => $arr_error[2]);
        }
    }
    
}
?>