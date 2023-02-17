<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);

$ID_USER =  $datos['ID_USER'];
$NOMBRE= $datos['NOMBRE'];
$APELLIDO = $datos['APELLIDO'];
$EMAIL =  $datos['EMAIL'];
$PASS  = $datos['PASS'];
$TELEFONO = $datos['TELEFONO'];


// $ID_USER = '28316441';
// $NOMBRE = 'Leonardo';
// $APELLIDO = 'Rivera';
// $EMAIL =  'leonardorivera1001@gmail.com';
// $PASS = '123456';
// $TELEFONO   = '584123579763';




$sql= "UPDATE `user` SET `NOMBRE`='".$NOMBRE."',`APELLIDO`='".$APELLIDO."',`EMAIL`='".$EMAIL."',`PASS`='".$PASS."',`TELEFONO`='".$TELEFONO."' WHERE user.ID_USER =".$ID_USER."";

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
        $respuesta ='SI';
        $respuestaArray[0] = $respuesta;
                
        }
        
    

    desconectar($conexion); //desconectamos la base de datos

    
    
        
    
  
    return $respuestaArray;
}       
        

if(strlen($ID_USER)<1 or strlen($NOMBRE) <1 or strlen($APELLIDO) <1 or strlen($EMAIL) <1 or strlen($PASS) <1 or strlen($TELEFONO) <1){
    echo json_encode('NO');
    //echo 'vacio';
}else{
    $r = obtenerArreglo($sql);
    echo json_encode($r[0]);
    //echo 'si pasa';
    

}
           
           

        
        

?>