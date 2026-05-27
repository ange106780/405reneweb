<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

require_once 'config.php';

header("Content-Type: application/json; charset=utf-8");

$valido = array(
    'success' => false,
    'mensaje' => ''
);

if($_POST){

    $accion = $_POST['accion'];

    switch($accion){
        // REGISTRAR

case "registrar":

    $correo =
    $_POST['correo'];

    $password =
    md5(
    $_POST['password']
    );

    $nombre =
    $_POST['nombre'];

    $sql = "

    INSERT INTO usuario(

    usuarioId,
    correo,
    password,
    nombre

    )

    VALUES(

    null,

    '$correo',

    '$password',

    '$nombre'

    )

    ";

    if(
    $cx->query($sql)
    ){

        $valido[
        'success'
        ]=true;

        $valido[
        'mensaje'
        ]=
        "USUARIO REGISTRADO";

    }else{

        $valido[
        'mensaje'
        ]=
        $cx->error;

    }

break;

        // LOGIN

        case "login":

            $username =
            $_POST['username'];

            $password =
            md5(
            $_POST['password']
            );

            $sql = "

            SELECT *

            FROM usuario

            WHERE correo=
            '$username'

            AND password=
            '$password'

            ";

            $resultado =
            $cx->query($sql);

            if(
            $resultado->num_rows>0
            ){

                $fila =
                $resultado
                ->fetch_assoc();

                $valido[
                'success'
                ]=true;

                $valido[
                'mensaje'
                ]=
                "INICIO DE
                SESION CORRECTO";

                $valido[
                'nombre'
                ]=
                $fila[
                'nombre'
                ];

            }else{

                $valido[
                'mensaje'
                ]=
                "USUARIO O
                PASSWORD
                INCORRECTO";

            }

        break;



        // AGREGAR CONTACTO

        case "agregar":

            $nombre =
            $_POST['nombre'];

            $ap =
            $_POST['ap'];

            $am =
            $_POST['am'];

            $telefono =
            $_POST['telefono'];

            $correo =
            $_POST['correo'];

            $sql="

            INSERT INTO
            contacto(

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

            if(
            $cx->query($sql)
            ){

                $valido[
                'success'
                ]=true;

                $valido[
                'mensaje'
                ]=
                "SE GUARDO";

            }

        break;



        // CARGAR TODOS

        case "cargarTodo":

            $sql=
            "SELECT *
            FROM contacto";

            $resultado=
            $cx->query(
            $sql
            );

            $salida=
            array(
            'data'=>
            array()
            );

            while(

            $row=
            $resultado
            ->fetch_array()

            ){

                $salida[
                'data'
                ][]=
                array(

                $row[0],

                $row[5],

                $row[1],

                $row[2],

                $row[3],

                $row[4]

                );

            }

            echo json_encode(
            $salida
            );

            exit;

        break;



        // CARGAR UNO

        case "cargar":

            $id=
            $_POST[
            'contactoId'
            ];

            $sql=
            "

            SELECT *

            FROM contacto

            WHERE
            contactoId=
            '$id'

            ";

            $resultado=
            $cx->query(
            $sql
            );

            if(
            $resultado
            ->num_rows>0
            ){

                $row=
                $resultado
                ->fetch_assoc();

                $valido=
                array_merge(

                $valido,

                $row

                );

                $valido[
                'success'
                ]=true;

            }

        break;



        // EDITAR

        case "editar":

            $id=
            $_POST[
            'contactoId'
            ];

            $nombre=
            $_POST[
            'nombre'
            ];

            $ap=
            $_POST[
            'ap'
            ];

            $am=
            $_POST[
            'am'
            ];

            $telefono=
            $_POST[
            'telefono'
            ];

            $correo=
            $_POST[
            'correo'
            ];

            $sql="

            UPDATE contacto

            SET

            nombre='$nombre',

            ap='$ap',

            am='$am',

            telefono='$telefono',

            correo='$correo'

            WHERE
            contactoId='$id'

            ";

            if(
            $cx->query($sql)
            ){

                $valido[
                'success'
                ]=true;

                $valido[
                'mensaje'
                ]=
                "ACTUALIZADO";

            }

        break;



        // ELIMINAR

        case "eliminar":

            $id=
            $_POST[
            'contactoId'
            ];

            $sql=
            "

            DELETE FROM
            contacto

            WHERE
            contactoId=
            '$id'

            ";

            if(
            $cx->query($sql)
            ){

                $valido[
                'success'
                ]=true;

                $valido[
                'mensaje'
                ]=
                "ELIMINADO";

            }

        break;

    }

}

echo json_encode(
$valido
);

?>