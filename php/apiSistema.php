```php
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

header("Content-Type: application/json; charset=utf-8");

$valido = array(
    'success' => false,
    'mensaje' => ''
);

if($_POST){

    $accion = $_POST['accion'];

    switch($accion){

        // ======================
        // REGISTRAR USUARIO
        // ======================
        case "registrar":

            $correo = $_POST['correo'];
            $password = md5($_POST['password']);
            $nombre = $_POST['nombre'];

            $sql = "INSERT INTO usuario(usuarioId, correo, password, nombre)
                    VALUES(null, '$correo', '$password', '$nombre')";

            if($cx->query($sql)){

                $valido['success'] = true;
                $valido['mensaje'] = "USUARIO REGISTRADO";

            }else{

                $valido['mensaje'] = "Error: " . $cx->error;

            }

        break;

        // ======================
        // LOGIN
        // ======================
        case "login":

            $username = $_POST['username'];
            $password = md5($_POST['password']);

            $sql = "SELECT * FROM usuario
                    WHERE correo='$username'
                    AND password='$password'";

            $resultado = $cx->query($sql);

            if($resultado->num_rows > 0){

                $fila = $resultado->fetch_assoc();

                $valido['success'] = true;
                $valido['mensaje'] = "INICIO DE SESION CORRECTO";
                $valido['nombre'] = $fila['nombre'];

            }else{

                $valido['mensaje'] = "USUARIO O PASSWORD INCORRECTO";

            }

        break;

        // ======================
        // AGREGAR CONTACTO
        // ======================
        case "agregar":

            $nombre = $_POST['nombre'];
            $ap = $_POST['ap'];
            $am = $_POST['am'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];

            $sql = "INSERT INTO contacto(contactoId, nombre, ap, am, telefono, correo)
                    VALUES(null, '$nombre', '$ap', '$am', '$telefono', '$correo')";

            if($cx->query($sql)){

                $valido['success'] = true;
                $valido['mensaje'] = "SE GUARDO";

            }else{

                $valido['mensaje'] = "Error: " . $cx->error;

            }

        break;

        // ======================
        // CARGAR TODOS LOS CONTACTOS
        // ======================
        case "cargarTodo":

            $sql = "SELECT * FROM contacto";

            $resultado = $cx->query($sql);

            $salida = array(
                'data' => array()
            );

            if($resultado){

                while($row = $resultado->fetch_assoc()){

                    $salida['data'][] = array(

                        "contactoId" => $row['contactoId'],
                        "nombre"     => $row['nombre'],
                        "ap"         => $row['ap'],
                        "am"         => $row['am'],
                        "telefono"   => $row['telefono'],
                        "correo"     => $row['correo']

                    );

                }

            }

            echo json_encode($salida);

            exit;

        break;

        // ======================
        // CARGAR UN CONTACTO
        // ======================
        case "cargar":

            $id = $_POST['contactoId'];

            $sql = "SELECT * FROM contacto WHERE contactoId='$id'";

            $resultado = $cx->query($sql);

            if($resultado->num_rows > 0){

                $row = $resultado->fetch_assoc();

                $valido = array_merge($valido, $row);

                $valido['success'] = true;

            }else{

                $valido['mensaje'] = "Contacto no encontrado";

            }

        break;

        // ======================
        // EDITAR CONTACTO
        // ======================
        case "editar":

            $id = $_POST['contactoId'];
            $nombre = $_POST['nombre'];
            $ap = $_POST['ap'];
            $am = $_POST['am'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];

            $sql = "UPDATE contacto
                    SET nombre='$nombre',
                        ap='$ap',
                        am='$am',
                        telefono='$telefono',
                        correo='$correo'
                    WHERE contactoId='$id'";

            if($cx->query($sql)){

                $valido['success'] = true;
                $valido['mensaje'] = "ACTUALIZADO";

            }else{

                $valido['mensaje'] = "Error: " . $cx->error;

            }

        break;

        // ======================
        // ELIMINAR CONTACTO
        // ======================
        case "eliminar":

            $id = $_POST['contactoId'];

            $sql = "DELETE FROM contacto WHERE contactoId='$id'";

            if($cx->query($sql)){

                $valido['success'] = true;
                $valido['mensaje'] = "ELIMINADO";

            }else{

                $valido['mensaje'] = "Error: " . $cx->error;

            }

        break;

        // ======================
        // CARGAR CITAS
        // ======================
        case "cargarCitas":

            $sql = "SELECT * FROM citas";

            $resultado = $cx->query($sql);

            $salida = array(
                'data' => array()
            );

            if($resultado){

                while($row = $resultado->fetch_assoc()){

                    $salida['data'][] = array(

                        "citaId"      => $row['citaId'],
                        "titulo"      => $row['titulo'],
                        "descripcion" => $row['descripcion'],
                        "fecha"       => $row['fecha'],
                        "hora"        => $row['hora'],
                        "lugar"       => $row['lugar'],
                        "estado"      => $row['estado']

                    );

                }

            }

            echo json_encode($salida);

            exit;

        break;

        // ======================
        // AGREGAR CITA
        // ======================
        case "agregarCita":

            $contactoId = $_POST['contactoId'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $lugar = $_POST['lugar'];
            $estado = $_POST['estado'];

            $sql = "INSERT INTO citas(citaId, contactoId, titulo, descripcion, fecha, hora, lugar, estado)
                    VALUES(null, '$contactoId', '$titulo', '$descripcion', '$fecha', '$hora', '$lugar', '$estado')";

            if($cx->query($sql)){

                $valido['success'] = true;
                $valido['mensaje'] = "CITA AGREGADA";

            }else{

                $valido['mensaje'] = "Error en la BD: " . $cx->error;

            }

        break;

        // ======================
        // CARGAR CITA
        // ======================
        case "cargarCita":

            $id = $_POST['citaId'];

            $sql = "SELECT * FROM citas WHERE citaId='$id'";

            $resultado = $cx->query($sql);

            if($resultado->num_rows > 0){

                $row = $resultado->fetch_assoc();

                $valido = array_merge($valido, $row);

                $valido['success'] = true;

            }else{

                $valido['mensaje'] = "Cita no encontrada";

            }

        break;

        // ======================
        // EDITAR CITA
        // ======================
        case "editarCita":

            $id = $_POST['citaId'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $lugar = $_POST['lugar'];
            $estado = $_POST['estado'];

            $sql = "UPDATE citas
                    SET titulo='$titulo',
                        descripcion='$descripcion',
                        fecha='$fecha',
                        hora='$hora',
                        lugar='$lugar',
                        estado='$estado'
                    WHERE citaId='$id'";

            if($cx->query($sql)){

                $valido['success'] = true;
                $valido['mensaje'] = "CITA ACTUALIZADA";

            }else{

                $valido['mensaje'] = "Error: " . $cx->error;

            }

        break;

        // ======================
        // ELIMINAR CITA
        // ======================
        case "eliminarCita":

            $id = $_POST['citaId'];

            $sql = "DELETE FROM citas WHERE citaId='$id'";

            if($cx->query($sql)){

                $valido['success'] = true;
                $valido['mensaje'] = "CITA ELIMINADA";

            }else{

                $valido['mensaje'] = "Error: " . $cx->error;

            }

        break;

    }

}

echo json_encode($valido);

?>
```
