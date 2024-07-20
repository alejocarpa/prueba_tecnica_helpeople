<?php 

include_once '../headers.php';

require_once 'cart.class.php';
require_once '../API/api.class.php';

//Api::validarAccesoApi();

$_cart = new Cart;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    $datosArray = $_cart->buscarDatos($_GET);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_cart->guardarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else{
    echo "metodo no permitido";
}

?>