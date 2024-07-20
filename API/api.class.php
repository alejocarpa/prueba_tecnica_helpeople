<?php

class Api {
    
    public function fncResponse($response){
        
        if(!empty($response)){
            
            $json = array(
                
                'status' => 200,
                'total' => count($response),
                'results' => $response
            );
            
        }else{
            
            $json = array(
                
                'status' => 404,
                'results' => 'Not found',
                'method' => 'get'
            );
            
        }
        
        echo json_encode($json);
        
    }
    
    public function keyJWT(){
        
        return $key = 'kjfau$kjaskf@kljsdfkj5154sadf45cc1*asdf%dsfkjfasf#df';
    }
    
    public function validarAccesoApi() {
        
        $headers = getallheaders();
        
        if( $headers['Authorization'] !== "EsTaEsmiPalabr@secretaDeTokENS123123" ){
            
            die("No tienes permiso para acceder");
        }
    }
    
}

?>