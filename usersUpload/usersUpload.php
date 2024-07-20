<?php 

include_once '../headers.php';

require_once 'usersUpload.class.php';
require_once '../API/api.class.php';

//Api::validarAccesoApi();

$_usersUpload = new UsersUpload;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postBody = file_get_contents("php://input");

    $datosArray = $_usersUpload->guardarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else{
    echo "metodo no permitido";
}

?>