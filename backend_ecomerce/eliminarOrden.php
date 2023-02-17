

<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);

$ID= $datos['ID'];




$sql = "DELETE FROM `orden` WHERE orden.ID_ORDEN ='".$ID."'";


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
};



function setNewUser($sql){
    //Creamos la conexion con la funcion anterior
    $respuesta='';
    $conexion = conectarDB();
    $respuestaArray = array();
    
    //generamos la consulta
    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
    
    if(!$resultado = mysqli_query($conexion, $sql)){
        $respuesta ='NO';
        
        //die(); //si la conexión cancelar programa  

    }else{
        $respuesta ='SI';
    }

    desconectar($conexion); //desconectamos la base de datos

    $respuestaArray = array();
    $respuestaArray[0] = $respuesta;
        
  
    return $respuestaArray;
    
}
     
    $res = setNewUser($sql);
    echo json_encode($res);
    

?>