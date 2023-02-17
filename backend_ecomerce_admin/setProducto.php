<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);



$ID_PRODUCT = $datos['ID_PRODUCT'];
$NOMBRE = $datos['NOMBRE'];
$PRECIO= $datos['PRECIO'];
$CANTIDAD = '0';
$DESCRIPCION = $datos['DESCRIPCION'];
$FECHA =  date('y-m-d');
$LIKES  ='0';
$CANTIDAD_VANDIDOS = '0';
$FILE = $datos['FILE'];

// $ID_PRODUCT = '555777552021';
// $NOMBRE = 'PRueba de termo';
// $PRECIO= '11';
// $CANTIDAD = '0';
// $DESCRIPCION = 'Termo de prueba';
// $FECHA =  '2023-02-12';
// $LIKES  ='0';
// $CANTIDAD_VANDIDOS = '0';
// $FILE = 'fghgfhgfg4ggggggg44444';

$sql = "INSERT INTO `product`(`ID_PRODUCT`, `NOMBRE`, `PRECIO`, `CANTIDAD`, `DESCRIPCION`, `FECHA`, `LIKES`, `CANTIDAD_VANDIDOS`, `FILE`) VALUES ('".$ID_PRODUCT."','".$NOMBRE."','".$PRECIO."','".$CANTIDAD."','".$DESCRIPCION."','".$FECHA."','".$LIKES."','".$CANTIDAD_VANDIDOS."','$FILE')";
$sqlUpdate = "UPDATE `product` SET `ID_PRODUCT`='".$ID_PRODUCT."',`NOMBRE`='".$NOMBRE."',`PRECIO`='".$PRECIO."',`CANTIDAD`='".$CANTIDAD."',`DESCRIPCION`='".$DESCRIPCION."',`FECHA`='".$FECHA."',`LIKES`='".$LIKES."',`CANTIDAD_VANDIDOS`='".$CANTIDAD_VANDIDOS."',`FILE`='".$FILE."' WHERE product.ID_PRODUCT = '".$ID_PRODUCT."'";

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
    $respuestaArray = array();
    
    $conexion = conectarDB();
    
    //generamos la consulta

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


   
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
    
};
function setUpdateUser($sqlUpdate){
    //Creamos la conexion con la funcion anterior
    $respuesta='';
    $respuestaArray = array();
    
    $conexion = conectarDB();
    
    //generamos la consulta

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8


   
        if(!$resultado = mysqli_query($conexion, $sqlUpdate)){
            $respuesta ='NO';
            $respuestaArray[0] = $respuesta;
            //die(); //si la conexión cancelar programa   
        }else{
            $respuesta ='SI';
                    
            }
        

    desconectar($conexion); //desconectamos la base de datos

    
    
        
  
    return $respuestaArray;
    
};





function validarUser($ID_PRODUCT){
    $conexion = conectarDB();
    $respuestaArray = array();
    $sql = "SELECT product.ID_PRODUCT from product WHERE product.ID_PRODUCT = '".$ID_PRODUCT."'";

    //generamos la consulta

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

        /**validamos si la cedula existe */
        if(!$resultado = mysqli_query($conexion, $sql)){
            $respuesta ='NO';
            $respuestaArray[0] = $respuesta;
            //die(); //si la conexión cancelar programa   
        }else{
            $row = mysqli_fetch_assoc($resultado);
            if($row != NULL){
                
                $respuestaArray[0] = $row['ID_PRODUCT'];
            }else{
                $respuesta ='NO';
                $respuestaArray[0] = $respuesta;
            }

         

        }


    desconectar($conexion); //desconectamos la base de datos

    
  
    return $respuestaArray;


}



$r= validarUser($ID_PRODUCT);


//echo json_encode($r);

$rID= $r[0];




if(strlen($ID_PRODUCT) <1 or strlen($NOMBRE) <1 or strlen($PRECIO) <1 or strlen($DESCRIPCION) <1 or strlen($FECHA) <1 or strlen($CANTIDAD_VANDIDOS) <1 or strlen($FILE) <1){
    $res[0] = 'NO1';

}else{


   
    if ($ID_PRODUCT != $rID) {
       setNewUser($sql);
       $res[0] = 'SI';
    }
    
    if ($ID_PRODUCT== $rID ) {
        /*echo 'NO tiene token';*/
        /*Update */
        setUpdateUser($sqlUpdate);
        $res[0] = 'SiUpdate';
    }

}



echo json_encode($res)

    




?>

