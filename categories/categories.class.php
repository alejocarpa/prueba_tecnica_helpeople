<?php 

include_once '../conexion/conexion.class.php';

class Categories {
    
    public function buscarDatos($datos){
        
        $where = "1=1";

        $id_category = $_GET['category'];
        
        if( isset($id_category) ) $where .= " AND id = :category";
        
        isset( $_GET['limit'] ) ? $limit = "LIMIT ".$_GET['limit'] : $limit = "" ;
        isset( $_GET['offset'] ) ? $offset = "OFFSET ".$_GET['offset'] : $offset = "" ;
        
        $link = Conexion::connect();
        
        $query = "SELECT *
                    FROM categories                    
                    WHERE $where
                    ORDER BY name ASC
                    $limit $offset";
        
        $stmt = $link->prepare($query);
        
        if( $id_category ) $stmt->bindParam(':category', $id_category);
        
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);
        
        $link = null;
        
        return $resultado;
    }
    
    public function guardarDatos($datos){
        
        $datos = json_decode($datos);
        
        $name = $datos->name_category;      
        
        $existeDato = Categories::existeDato( $name );
        
        if( $existeDato ){
            
            return array("error" => "El producto ya existe");
        }
        
        $link = Conexion::connect();
        
        $stmt = $link->prepare("INSERT INTO categories (name, created_at, updated_at) 
                                                VALUES (:name, current_timestamp, current_timestamp)");
        
        $stmt->bindParam(':name', $name);
        
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
    
    public function actualizarDatos($datos){
        
        $datos = json_decode($datos);
        
        $id_category = $_GET['category'];
        
        $name = $datos->name_category; 
        
        $link = Conexion::connect();
        
        $query = "UPDATE categories SET name = :name_category,
                                      updated_at = current_timestamp
                                WHERE id = :category";
        $stmt = $link->prepare($query);
        
        $stmt->bindParam(':name_category', $name);
        $stmt->bindParam(':category', $id_category);
        
        // Excecute
        if($stmt->execute()){
            
            $resultado = array(
                'comment' => 'The process was successful'
            );
            
            return $resultado;
            
        }else{
            return $link->errorInfo();
        }
    }
    
    public function eliminarDatos(){
        
        $id_category = $_GET['category'];
        
        $link = Conexion::connect();
        
        $query = "DELETE FROM categories WHERE id = :category";
        
        $stmt = $link->prepare($query);
        
        $stmt->bindParam(':category', $id_category);
        
        $stmt->execute();
        
        $link = null;
        
        return array("Message" => "Se elimino la categoria con id $id_category");
    }
    
    public function existeDato($nombre){
        
        $nombre = str_replace( ' ', '', strtolower( $nombre ) );
        
        $link = Conexion::connect();
        
        $query = "SELECT *
                    FROM categories
                    WHERE REPLACE(lower(name), ' ', '') = :name";
        
        $stmt = $link->prepare($query);
        
        $stmt->bindParam(':name', $nombre);
        
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);
        
        $link = null;
        
        return $resultado[0]->id;
    }
}
?>