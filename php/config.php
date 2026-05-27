<?php

$server = "localhost";
$user = "root";
$pass = "";
$bd = "ejercicio";

$cx = mysqli_connect($server, $user, $pass, $bd);

if($cx){
   // echo "Conexión exitosa";
}else{
   // echo "Error de conexión";
}

?>