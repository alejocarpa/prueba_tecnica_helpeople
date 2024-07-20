<?php 

include_once '../headers.php';

require_once 'products.class.php';
require_once '../API/api.class.php';

//Api::validarAccesoApi();

$_product = new Products;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    $datosArray = $_product->buscarDatos($_GET);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_product->guardarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_product->actualizarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
    $datosArray = $_product->eliminarDatos();
    
    Api::fncResponse($datosArray);
    
}else{
    echo "metodo no permitido";
}

?>