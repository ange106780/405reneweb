<?php

require_once '../config.php';

$valido = array(
    'success' => false,
    'mensaje' => ""
);

if($_POST){

    // RECIBIR DATOS DEL FORMULARIO
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // CONSULTA
    $sql = "SELECT * FROM usuario
            WHERE correo='$username'
            AND password='$password'";

    // EJECUTAR CONSULTA
    $resultado = $cx->query($sql);

    // CONTAR RESULTADOS
    $n = $resultado->num_rows;

    // VALIDAR SI EXISTE EL USUARIO
    if($n > 0){

        $fila = $resultado->fetch_assoc();

        $valido['success'] = true;
        $valido['mensaje'] = "INICIO DE SESION CORRECTO";
        $valido['nombre'] = $fila['nombre'];

    }else{

        $valido['success'] = false;
        $valido['mensaje'] = "USUARIO O PASSWORD INCORRECTO";

    }

}

// RETORNAR RESPUESTA JSON
echo json_encode($valido);

?>