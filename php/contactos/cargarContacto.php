<?php
require_once '../config.php';

header("Content-Type: application/json; charset=utf-8");

$valido = array(
    'success' => false,
    'mensaje' => '',
    'contactoid' => '',
    'nombre' => '',
    'ap' => '',
    'am' => '',
    'telefono' => '',
    'correo' => ''
);

if(isset($_POST['contactoId'])){

    $id = $_POST['contactoId'];

    $sql = "SELECT * FROM contacto WHERE contactoId='$id'";

    $resultado = $cx->query($sql);

    if($resultado && $resultado->num_rows > 0){

        $row = $resultado->fetch_array();

        $valido['success'] = true;
        $valido['mensaje'] = 'SE ENCONTRO REGISTRO';

        $valido['contactoid'] = $row[0];
        $valido['ap'] = $row[1];
        $valido['am'] = $row[2];
        $valido['telefono'] = $row[3];
        $valido['correo'] = $row[4];
        $valido['nombre'] = $row[5];

    }else{

        $valido['mensaje'] = 'NO SE ENCONTRO EL CONTACTO';

    }

}else{

    $valido['mensaje'] = 'NO SE RECIBIO contactoId';

}

$cx->close();

echo json_encode($valido);
?>