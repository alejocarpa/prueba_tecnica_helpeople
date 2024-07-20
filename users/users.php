<?php 

include_once '../headers.php';

require_once 'users.class.php';
require_once '../API/api.class.php';

//Api::validarAccesoApi();

$_user = new Users;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postBody = file_get_contents("php://input");

    $datosArray = $_user->guardarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else{
    echo "metodo no permitido";
}

?>