<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
$datos = json_decode(file_get_contents("php://input"), true);
$ID_USER = $datos['ID_USER'];
$sql1= "SELECT STATUS from orden INNER join user on user.ID_USER = orden.ID_USER WHERE user.ID_USER = '".$ID_USER."' and orden.STATUS ='1';";
$sql2= "SELECT STATUS from orden INNER join user on user.ID_USER = orden.ID_USER WHERE user.ID_USER = '".$ID_USER."' and orden.STATUS ='2';";
$sql3= "SELECT STATUS from orden INNER join user on user.ID_USER = orden.ID_USER WHERE user.ID_USER = '".$ID_USER."' and orden.STATUS ='3';";
$sql4= "SELECT STATUS from orden INNER join user on user.ID_USER = orden.ID_USER WHERE user.ID_USER = '".$ID_USER."' ;";
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

function obtenerArreglo($sql1,$sql2,$sql3,$sql4){
    //Creamos la conexion con la funcion anterior
  $conexion = conectarDB();
  $arreglo = array(); //creamos un array
  $i=0;
    //generamos la consulta

    mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

    if(!$resultado = mysqli_query($conexion, $sql1)) die(); //si la conexión cancelar programa
    while($row = mysqli_fetch_assoc($resultado))
    {
        $i++;
    }
    
    $arreglo[0] =$i;
    $i=0;

    if(!$resultado = mysqli_query($conexion, $sql2)) die(); //si la conexión cancelar programa
    while($row = mysqli_fetch_assoc($resultado))
    {
        $i++;
    }
    
    $arreglo[1] =$i;
    $i=0;

    if(!$resultado = mysqli_query($conexion, $sql3)) die(); //si la conexión cancelar programa
    while($row = mysqli_fetch_assoc($resultado))
    {
        $i++;
    }
    
    $arreglo[2] =$i;
    $i=0;
    if(!$resultado = mysqli_query($conexion, $sql4)) die(); //si la conexión cancelar programa
    while($row = mysqli_fetch_assoc($resultado))
    {
        $i++;
    }
    
    $arreglo[3] =$i;
    $i=0;
        
    

    desconectar($conexion); //desconectamos la base de datos

    return $arreglo; //devolvemos el array
}

        $r = obtenerArreglo($sql1,$sql2,$sql3,$sql4);
        echo json_encode($r);

?>