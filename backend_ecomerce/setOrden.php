<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);



$STATUS='1';
$ID_USER = $datos['ID_USER'];
//$ID_USER = '2831644';
$FECHA= date('y-m-d');
$SUB_TOTAL= $datos['SUB_TOTAL'];
$TOTAL= $datos['TOTAL'];
$productos= $datos['PRODUCTOS'];
$TELEFONO = $datos['TELEFONO'];

//$STATUS='1';
//$ID_USER = '28316441';
//$FECHA= date('y-m-d');
//$SUB_TOTAL= '40';
//$TOTAL= '40';
//$productos = ['555552021','555552021','555552021','555552021'];




$sql = "INSERT INTO `orden` (`ID_ORDEN`, `STATUS`, `ID_USER`, `FECHA`, `SUB_TOTAL`, `TOTAL`) VALUES (NULL, '".$STATUS."', '".$ID_USER."', '".$FECHA."', '".$SUB_TOTAL."', '".$TOTAL."');";
$sql2 = "SELECT orden.ID_ORDEN from orden WHERE orden.ID_USER= '".$ID_USER."' ORDER BY orden.ID_ORDEN DESC LIMIT 1;";

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



function setNewOrden($sql,$sql2){
    //Creamos la conexion con la funcion anterior
    $respuesta='';
    $respuestaArray = array();
    
    $conexion = conectarDB();
    
    //generamos la consulta

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


   
        if(!$resultado = mysqli_query($conexion, $sql)){
            $respuesta ='NO';
            $respuestaArray[0] = $respuesta;
            //die(); //si la conexión cancelar programa   
        }else{
            $respuesta ='SE CREO LA ORDEN';
            if(!$resultado = mysqli_query($conexion, $sql2)) die(); //si la conexión cancelar programa

                //guardamos en un array todos los datos de la consulta


                $row = mysqli_fetch_assoc($resultado);
                $respuestaArray[0] = $row;
                    
            }
        

    desconectar($conexion); //desconectamos la base de datos

    
    
        
  
    return $respuestaArray;
    
};



function setOrdenProducto($orden,$productos){
    
    //$sql3 ="INSERT INTO `orden_producto` (`ID_ORDEN`, `ID_PRODUCT`) VALUES ";
    
    $conexion = conectarDB();
    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

    foreach($productos as $item){
        
        $sql3 ="INSERT INTO `orden_producto` (`ID_ORDEN`, `ID_PRODUCT`) VALUES ('".$orden."', '".$item."');";
        mysqli_query($conexion, $sql3);
        
    }
    
    
    //mysqli_query($conexion, $sql3);
    desconectar($conexion);
    

    


}


function setNewUser($ID_USER,$TELEFONO){

    $sql = "INSERT INTO `user` (`ID_USER`, `NOMBRE`, `APELLIDO`, `EMAIL`, `PASS`, `TELEFONO`, `token`) VALUES ('".$ID_USER."', '', '', NULL, '', '+".$TELEFONO."', NULL);";
    $conexion = conectarDB();
    $respuesta='';

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
    
    mysqli_query($conexion, $sql);
    if(!$resultado = mysqli_query($conexion, $sql)){
       
        //die(); //si la conexión cancelar programa   
    }
    desconectar($conexion); //desconectamos la base de datos
    
    
    
}

function validarUser($ID){
    $conexion = conectarDB();
    $respuestaArray = array();
    $sql = "SELECT user.ID_USER FROM `user` WHERE user.ID_USER = '".$ID."';";
    //generamos la consulta

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

  
        if(!$resultado = mysqli_query($conexion, $sql)){
            $respuesta ='NO';
            $respuestaArray[0] = $respuesta;
            //die(); //si la conexión cancelar programa   
        }else{
            $row = mysqli_fetch_assoc($resultado);
            $respuestaArray[0] = $row;
         

        }
    

    desconectar($conexion); //desconectamos la base de datos

    
  
    return $respuestaArray;


}



$r= validarUser($ID_USER);
$r= $r[0];
$r= $r['ID_USER'];
if($ID_USER != $r){
    setNewUser($ID_USER,$TELEFONO);
    
}


$res = setNewOrden($sql,$sql2);
$res = $res[0];
$res['ID_ORDEN'];
    
setOrdenProducto($res['ID_ORDEN'],$productos) ;
    




?>

