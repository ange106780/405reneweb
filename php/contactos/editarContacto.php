<?php

require_once '../config.php';

$valido = array(
    'success' => false,
    'mensaje' => ''
);

if($_POST){

    $id = $_POST['contactoId'];
    $nombre = $_POST['nombre'];
    $ap = $_POST['ap'];
    $am = $_POST['am'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sqlEditar = "
    UPDATE contacto 
    SET 
        nombre='$nombre',
        ap='$ap',
        am='$am',
        telefono='$telefono',
        correo='$correo'
    WHERE contactoId='$id'
    ";

    if($cx->query($sqlEditar) === true){

        $valido['success'] = true;
        $valido['mensaje'] = "SE ACTUALIZO CORRECTAMENTE";

    }else{

        $valido['success'] = false;
        $valido['mensaje'] = "ERROR AL ACTUALIZAR";

    }

}else{

    $valido['mensaje'] = "NO SE RECIBIERON DATOS";

}

echo json_encode($valido);

?>