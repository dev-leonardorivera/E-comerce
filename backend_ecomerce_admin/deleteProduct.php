<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);
$ID=  $datos['ID'];





$sql= "DELETE FROM `product` WHERE product.ID_PRODUCT='".$ID."'";

include "conectar.php";
//sleep(1);
function desconectar($conexion){

    $close = mysqli_close($conexion);

        if($close){
            echo '';
        }else{
            echo 'Ha sucedido un error inexperado en la conexión de la base de datos';
        }

    return $close;
}

function obtenerArreglo($sql){
    //Creamos la conexion con la funcion anterior
  $conexion = conectarDB();
  $respuestaArray = array();
    //generamos la consulta
    if(!$resultado = mysqli_query($conexion, $sql)){
      
        $respuesta ='N00O';
        $respuestaArray[0] = $respuesta;
        //die(); //si la conexión cancelar programa   
    }else{
        $respuesta ='SI';
        $respuestaArray[0] = $respuesta;
                
        }
        
    

    desconectar($conexion); //desconectamos la base de datos
  
    return $respuestaArray;
}           


    if(strlen($ID)>1){
        $r = obtenerArreglo($sql);
        echo json_encode($r[0]);
    }else{
        echo json_encode('NO');
    }
        
        

?>