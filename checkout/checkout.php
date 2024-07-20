<?php 

include_once '../headers.php';

require_once 'checkout.class.php';
require_once '../API/api.class.php';

//Api::validarAccesoApi();

$_checkout = new Checkout;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postBody = file_get_contents("php://input");

    $datosArray = $_checkout->guardarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else{
    echo "metodo no permitido";
}

?>