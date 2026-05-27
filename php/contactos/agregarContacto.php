<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

require_once '../config.php';

$valido = array(
    "success" => false,
    "mensaje" => ""
);

if($_POST){

    $nombre = $_POST['nombre'];
    $ap = $_POST['ap'];
    $am = $_POST['am'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sqlInsertar = "

    INSERT INTO contacto(

        contactoId,
        nombre,
        ap,
        am,
        telefono,
        correo

    )

    VALUES(

        null,
        '$nombre',
        '$ap',
        '$am',
        '$telefono',
        '$correo'

    )

    ";

    if($cx->query($sqlInsertar)){

        $valido['success'] = true;

        $valido['mensaje'] =
        "SE GUARDO CORRECTAMENTE";

    }else{

        $valido['success'] = false;

        $valido['mensaje'] =
        $cx->error;

    }

}else{

    $valido['mensaje'] =
    "NO LLEGARON DATOS";

}

echo json_encode($valido);

?>