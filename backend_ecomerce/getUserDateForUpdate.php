<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);

$ID_USER =  $datos['ID_USER'];
//$ID_USER ='28316441';



$sql= "SELECT user.EMAIL , user.NOMBRE , user.APELLIDO, user.TELEFONO , user.PASS from user WHERE user.ID_USER = '".$ID_USER."';";

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
        $respuesta ='NO';
        $respuestaArray[0] = $respuesta;
        //die(); //si la conexión cancelar programa   
    }else{
        $row = mysqli_fetch_assoc($resultado);
        $respuestaArray[0] = $row;

        if(!isset($respuestaArray[0]) ){
            $respuestaArray[0]= 'NOEXISTE';
        }
    }
        
    

    desconectar($conexion); //desconectamos la base de datos

    
    
        
    
  
    return $respuestaArray;
}
        
            $r = obtenerArreglo($sql);
            echo json_encode($r[0]);

        
        

?>