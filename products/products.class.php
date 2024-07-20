<?php 

include_once '../conexion/conexion.class.php';

class Products {
    
    public function buscarDatos($datos){
        
        $where = "1=1";

        $id_product = $_GET['product'];
        
        if( isset($id_product) ) $where .= " AND p.id = :product";
        
        isset( $_GET['limit'] ) ? $limit = "LIMIT ".$_GET['limit'] : $limit = "" ;
        isset( $_GET['offset'] ) ? $offset = "OFFSET ".$_GET['offset'] : $offset = "" ;
        
        $link = Conexion::connect();
        
        $query = "SELECT p.*, c.name as name_category
                    FROM products p
                    LEFT JOIN categories c on (c.id = p.category_id)                    
                    WHERE $where
                    ORDER BY p.name ASC
                    $limit $offset";
        
        $stmt = $link->prepare($query);
        
        if( $id_product ) $stmt->bindParam(':product', $id_product);
        
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);
        
        $link = null;
        
        return $resultado;
    }
    
    public function guardarDatos($datos){
        
        $datos = json_decode($datos);
        
        $name =          $datos->name_product;
        $description =   $datos->description_product;
        $price =         $datos->price_product;
        $category =      $datos->category_product;        
        
        $existeDato = Products::existeDato( $name, $category );
        
        if( $existeDato ){
            
            return array("error" => "El producto ya existe");
        }
        
        $link = Conexion::connect();
        
        $stmt = $link->prepare("INSERT INTO products (name, description, price, category_id,
                                                       created_at, updated_at) 
                                                VALUES (:name, :description, :price, :category,
                                                        current_timestamp, current_timestamp)");
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        
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
        
        $product = $_GET['product'];
        
        $name =          $datos->name_product;
        $description =   $datos->description_product;
        $price =         $datos->price_product;
        $category =      $datos->category_product;  
        
        $link = Conexion::connect();
        
        $query = "UPDATE products SET name = :name_product,
                                      description = :description_product,
                                        price = :price_product,
                                        category_id = :category_product,
                                        updated_at = current_timestamp
                                WHERE id = :product";
        $stmt = $link->prepare($query);
        
        $stmt->bindParam(':name_product', $name);
        $stmt->bindParam(':description_product', $description);
        $stmt->bindParam(':price_product', $price);
        $stmt->bindParam(':category_product', $category);
        $stmt->bindParam(':product', $product);
        
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
        
        $product = $_GET['product'];
        
        $link = Conexion::connect();
        
        $query = "DELETE FROM products WHERE id = :product";
        
        $stmt = $link->prepare($query);
        
        $stmt->bindParam(':product', $product);
        
        $stmt->execute();
        
        $link = null;
        
        return array("Message" => "Se elimino el producto con id $product");
    }
    
    public function existeDato($nombre, $categoria){
        
        $nombre = str_replace( ' ', '', strtolower( $nombre ) );
        
        $link = Conexion::connect();
        
        $query = "SELECT *
                    FROM products
                    WHERE REPLACE(lower(name), ' ', '') = :name and category_id = :category";
        
        $stmt = $link->prepare($query);
        
        $stmt->bindParam(':name', $nombre);
        $stmt->bindParam(':category', $categoria);
        
        $stmt->execute();
        
        $resultado = $stmt->fetchAll(PDO::FETCH_CLASS);
        
        $link = null;
        
        return $resultado[0]->id;
    }
}
?>