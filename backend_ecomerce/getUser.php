<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);

$EMAIL = '0';
$PASS  = '0';



if(isset($datos['EMAIL']) and  isset($datos['PASS'])){
    $EMAIL =  $datos['EMAIL'];
    $PASS  = $datos['PASS'];
}
if($datos['EMAIL']=='' and $datos['PASS']==''){
    $EMAIL = '0';
    $PASS  = '0';
}




//$EMAIL ='leonardorivera1004@gmail.com';
//$PASS  ='123456';




$sql= "SELECT user.ID_USER, user.NOMBRE, user.APELLIDO from user WHERE user.EMAIL='".$EMAIL."' and user.PASS='".$PASS."';";

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

function obtenerArreglo($sql, $EMAIL, $PASS){
    //Creamos la conexion con la funcion anterior
  $conexion = conectarDB();
  $respuestaArray = array();
  
    //generamos la consulta

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

    if( $EMAIL== '0'||$PASS =='0'){   
        
        $respuestaArray[0] = 'VACIO';
    }else{
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
    }

    desconectar($conexion); //desconectamos la base de datos

    
    
        
    
  
    return $respuestaArray;
}
        
            $r = obtenerArreglo($sql, $EMAIL, $PASS);
            echo json_encode($r);

        
        

?>