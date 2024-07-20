<?php 

include_once '../headers.php';

require_once 'categories.class.php';
require_once '../API/api.class.php';

//Api::validarAccesoApi();

$_category = new Categories;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    $datosArray = $_category->buscarDatos($_GET);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_category->guardarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_category->actualizarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
    $datosArray = $_category->eliminarDatos();
    
    Api::fncResponse($datosArray);
    
}else{
    echo "metodo no permitido";
}

?>