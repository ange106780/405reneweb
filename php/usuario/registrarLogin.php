<?php

require_once '../config.php';

$valido = array(
    'success' => false,
    'mensaje' => ""
);

if($_POST){

    $accion = $_POST['accion'];

    switch($accion){

        // REGISTRAR USUARIO
        case "registrar":

            $correo = $_POST['correo'];
            $password = md5($_POST['password']);
            $nombre = $_POST['nombre'];

            $sql = "
            SELECT * FROM usuario
            WHERE correo='$correo'
            ";

            $resultado = $cx->query($sql);

            $n = $resultado->num_rows;

            if($n == 0){

                $sqlInsertar = "
                INSERT INTO usuario
                VALUES(
                    null,
                    '$correo',
                    '$password',
                    '$nombre'
                )
                ";

                if($cx->query($sqlInsertar)){

                    $valido['success'] = true;
                    $valido['mensaje'] =
                    "SE GUARDÓ CORRECTAMENTE";

                }else{

                    $valido['success'] = false;
                    $valido['mensaje'] =
                    "ERROR: NO SE GUARDÓ";

                }

            }else{

                $valido['success'] = false;
                $valido['mensaje'] =
                "ESE USUARIO YA ESTÁ EN USO";

            }

        break;


        // LOGIN
        case "login":

            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $sql = "
            SELECT * FROM usuario
            WHERE correo='$username'
            AND password='$password'
            ";

            $resultado = $cx->query($sql);

            $n = $resultado->num_rows;

            if($n > 0){

                $fila =
                $resultado->fetch_assoc();

                $valido['success'] = true;

                $valido['mensaje'] =
                "INICIO DE SESION CORRECTO";

                $valido['nombre'] =
                $fila['nombre'];

            }else{

                $valido['success'] = false;

                $valido['mensaje'] =
                "USUARIO O PASSWORD INCORRECTO";

            }

        break;


        default:

            $valido['success'] = false;

            $valido['mensaje'] =
            "ACCION NO VALIDA";

        break;

    }

}else{

    $valido['success'] = false;

    $valido['mensaje'] =
    "NO SE RECIBIERON DATOS";

}

echo json_encode($valido);

?>