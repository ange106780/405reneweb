<?php

error_reporting(E_ALL);
ini_set(
'display_errors',
1
);

require_once '../config.php';

header(
"Content-Type:
application/json;
charset=utf-8"
);

$valido = array(

    'success' => false,

    'mensaje' => ''

);


if($_POST){

    $accion =
    $_POST['accion'];

    switch($accion){


        // AGREGAR

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


            $sql = "

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


            if($cx->query($sql)){

                $valido[
                'success'
                ] = true;

                $valido[
                'mensaje'
                ] =
                "SE GUARDO
                CORRECTAMENTE";

            }else{

                $valido[
                'mensaje'
                ] =
                $cx->error;

            }

        break;



        // CARGAR UN CONTACTO

        case "cargar":

            $id =
            $_POST[
            'contactoId'
            ];

            $sql = "

            SELECT *

            FROM contacto

            WHERE contactoId=
            '$id'

            ";

            $resultado =
            $cx->query(
            $sql
            );


            if(

            $resultado

            &&

            $resultado
            ->num_rows >0

            ){

                $row =
                $resultado
                ->fetch_assoc();


                $valido[
                'success'
                ] = true;

                $valido[
                'contactoid'
                ] =
                $row[
                'contactoId'
                ];

                $valido[
                'nombre'
                ] =
                $row[
                'nombre'
                ];

                $valido[
                'ap'
                ] =
                $row[
                'ap'
                ];

                $valido[
                'am'
                ] =
                $row[
                'am'
                ];

                $valido[
                'telefono'
                ] =
                $row[
                'telefono'
                ];

                $valido[
                'correo'
                ] =
                $row[
                'correo'
                ];

            }

        break;



        // CARGAR TODOS

        case "cargarTodo":

            $sql =
            "SELECT *
            FROM contacto";

            $resultado =
            $cx->query(
            $sql
            );

            $salida =
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



        // EDITAR

        case "editar":

            $id =
            $_POST[
            'contactoId'
            ];

            $nombre =
            $_POST[
            'nombre'
            ];

            $ap =
            $_POST[
            'ap'
            ];

            $am =
            $_POST[
            'am'
            ];

            $telefono =
            $_POST[
            'telefono'
            ];

            $correo =
            $_POST[
            'correo'
            ];


            $sql = "

            UPDATE
            contacto

            SET

            nombre=
            '$nombre',

            ap=
            '$ap',

            am=
            '$am',

            telefono=
            '$telefono',

            correo=
            '$correo'

            WHERE
            contactoId=
            '$id'

            ";


            if($cx->query($sql)){

                $valido[
                'success'
                ] = true;

                $valido[
                'mensaje'
                ] =
                "SE ACTUALIZO
                CORRECTAMENTE";

            }

        break;



        // ELIMINAR

        case "eliminar":

            $id =
            $_POST[
            'contactoId'
            ];

            $sql = "

            DELETE FROM
            contacto

            WHERE
            contactoId=
            '$id'

            ";


            if($cx->query($sql)){

                $valido[
                'success'
                ] = true;

                $valido[
                'mensaje'
                ] =
                "SE ELIMINO
                CORRECTAMENTE";

            }

        break;



        default:

            $valido[
            'mensaje'
            ] =
            "ACCION
            INVALIDA";

        break;

    }

}

echo json_encode(
$valido
);

?>