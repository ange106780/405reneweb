<?php

require_once '../config.php';

$valido = array(
    'success' => false,
    'mensaje' => ""
);

if($_POST){

    $correo = $_POST['correo'];
    $password = md5($_POST['password']);
    $nombre = $_POST['nombre'];

    $sql = "SELECT * FROM usuario WHERE correo='$correo'";

    $resultado = $cx->query($sql);

    $n = $resultado->num_rows;

    if($n == 0){

        $sqlInsertar = "
        INSERT INTO usuario 
        VALUES(null,'$correo','$password','$nombre')
        ";

        if($cx->query($sqlInsertar) === true){

            $valido['success'] = true;
            $valido['mensaje'] = "SE GUARDÓ CORRECTAMENTE";

        }else{

            $valido['success'] = false;
            $valido['mensaje'] = "ERROR: NO SE GUARDÓ";

        }

    }else{

        $valido['success'] = false;
        $valido['mensaje'] = "ESE USUARIO YA ESTÁ EN USO";

    }

}else{

    $valido['success'] = false;
    $valido['mensaje'] = "NO SE GUARDÓ";

}

echo json_encode($valido);

?>