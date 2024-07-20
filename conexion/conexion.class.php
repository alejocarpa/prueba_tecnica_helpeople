<?php

class Conexion {

	/* ================================================
    * Informacion de la base de datos
    ================================================== */
    static private function infoDatabase(){
        
        $infoDB = array(
            "database" => "u218692512_shopping",
            "user" => "u218692512_shopping",
            "pass" => "0C!gFK8c*g"
        );

        return $infoDB;

    }
    
    /* ================================================
     * Conexion a la base de datos
     ================================================== */
    static public function connect(){
        
        try{
            
            $link = new PDO(
                "mysql:host=localhost;dbname=".Conexion::infoDatabase()['database'],
                Conexion::infoDatabase()['user'],
                Conexion::infoDatabase()['pass']
                );
            
            $link->exec("set names utf8");
            
        }catch(PDOException $e){
            die("Error: ".$e->getMessage());
        }
        
        return $link;
    }
}