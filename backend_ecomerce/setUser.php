<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);



$ID_USER = $datos['ID_USER'];
$token = $datos['TOKEN'];
$NOMBRE= $datos['NOMBRE'];
$APELLIDO = $datos['APELLIDO'];
$EMAIL =  $datos['EMAIL'];
$PASS  = $datos['PASS'];
$TELEFONO = $datos['TELEFONO'];

// $ID_USER = '28316443';
// $token = '123asdsadasdsadasd455';
// $NOMBRE = 'Leonardo';
// $APELLIDO = 'Rivera';
// $EMAIL =  'leonardorivera1001@gmail.com';
// $PASS = '123456';
// $TELEFONO   = '+584123579763';

$sql = "INSERT INTO `user` (`ID_USER`, `NOMBRE`, `APELLIDO`, `EMAIL`, `PASS`, `TELEFONO`, `token`) VALUES ('".$ID_USER."', '".$NOMBRE."', '".$APELLIDO."','".$EMAIL."', '".$PASS."', '".$TELEFONO."', '".$token."');";
$sqlUpdate = $sqlUpdate = "UPDATE`user`SET`NOMBRE`='".$NOMBRE."',`APELLIDO`='".$APELLIDO."',`EMAIL`='".$EMAIL ."',`PASS`='".$PASS."',`TELEFONO`='".$TELEFONO."',`token`='".$token."' WHERE user.ID_USER = '".$ID_USER."'";

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





function validarUser($ID,$EMAIL,$token){
    $conexion = conectarDB();
    $respuestaArray = array();
    $sql = "SELECT user.ID_USER FROM `user` WHERE user.ID_USER = '".$ID."';";
    $sql1 = "SELECT user.EMAIL FROM `user` WHERE user.EMAIL = '".$EMAIL."';";
    $sql2 = "SELECT user.token  FROM `user` WHERE user.token = '".$token."';";
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
                
                $respuestaArray[0] = $row['ID_USER'];
            }else{
                $respuesta ='NO';
                $respuestaArray[0] = $respuesta;
            }

         

        }

        /**validamos si el email existe */
        if(!$resultado = mysqli_query($conexion, $sql1)){
            $respuesta ='NO';
            $respuestaArray[1] = $respuesta;
            //die(); //si la conexión cancelar programa   
        }else{
            $row = mysqli_fetch_assoc($resultado);
            if($row != NULL){
                $respuestaArray[1] = $row['EMAIL'];
            }else{
                $respuesta ='NO';
                $respuestaArray[1] = $respuesta;
            }
         

        }

        /**validamos si el token */
        if(!$resultado = mysqli_query($conexion, $sql2)){
            $respuesta ='NO';
            $respuestaArray[2] = $respuesta;
            //die(); //si la conexión cancelar programa   
        }else{
            $row = mysqli_fetch_assoc($resultado);
            if($row != NULL){
                
                $respuestaArray[2] = $row['token'];
            }else{
                $respuesta ='NO';
                $respuestaArray[2] = $respuesta;
            }

            

         

        }
    

    desconectar($conexion); //desconectamos la base de datos

    
  
    return $respuestaArray;


}

function validarTokenUser($ID){
    $conexion = conectarDB();
    $respuestaArray = array();
    $sql = "SELECT user.token  FROM `user` WHERE user.ID_USER = '".$ID."';";
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
                
                $respuestaArray[0] = $row['token'];
            }else{
                $respuesta ='NO';
                $respuestaArray[0] = $respuesta;
            }

         

        }

     

      

    desconectar($conexion); //desconectamos la base de datos

    
  
    return $respuestaArray;


}


$r= validarUser($ID_USER,$EMAIL,$token);

//echo json_encode($r);

$rID= $r[0];

$rEMAIL= $r[1];

$rtoken= $r[2];

$tokenUser = validarTokenUser($ID_USER)[0];

if(strlen($ID_USER) <1 or strlen($token) <1 or strlen($NOMBRE) <1 or strlen($APELLIDO) <1 or strlen($EMAIL) <1 or strlen($PASS) <1 or strlen($TELEFONO) <1){
    $res[0] = 'NO1';

}else{


    if($EMAIL == $rEMAIL or $ID_USER == $rID or $token == $rtoken ){
        $res[0] = 'NO';
    }
    
    if ($ID_USER != $rID and $EMAIL != $rEMAIL and $token != $rtoken) {
       setNewUser($sql);
       $res[0] = 'SI';
    }
    
    if ($ID_USER == $rID and $tokenUser == null and $rEMAIL=='NO') {
        /*echo 'NO tiene token';*/
        /*Update */
        setUpdateUser($sqlUpdate);
        $res[0] = 'SiUpdate';
    }

}



echo json_encode($res)

    




?>

