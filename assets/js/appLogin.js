var sesion = localStorage.getItem("nombre");

const checarSesion = () => {

    if(sesion != null){

        window.location.href = "inicio.html";

    }

}

const registrarUsuario = async() => {

    var correo =
    document.querySelector("#correo").value;

    var password =
    document.querySelector("#password").value;

    var nombre =
    document.querySelector("#nombre").value;

    if(

        correo.trim() === '' ||

        password.trim() === '' ||

        nombre.trim() === ''

    ){

        Swal.fire({

            icon:'error',

            title:'ERROR',

            text:'FALTA LLENAR CAMPOS',

            footer:'CRUD CONTACTOS'

        });

        return;

    }

    if(!validarCorreo(correo)){

        Swal.fire({

            icon:'error',

            title:'ERROR',

            text:
            'INTRODUCE UN CORREO ELECTRÓNICO VÁLIDO',

            footer:'CRUD CONTACTOS'

        });

        return;

    }

    if(!validarPassword(password)){

        Swal.fire({

            icon:'error',

            title:'ERROR',

            html:
            'INTRODUCE UN PASSWORD VALIDO <br> [Mayusculas, minusculas, numeros y min. 8 Caracteres]',

            footer:'CRUD CONTACTOS'

        });

        return;

    }

    if(!validarNombre(nombre)){

        Swal.fire({

            icon:'error',

            title:'ERROR',

            text:
            'INTRODUCE UN NOMBRE VÁLIDO',

            footer:'CRUD CONTACTOS'

        });

        return;

    }


    // DATOS

    const datos = new FormData();

    datos.append(
    "correo",
    correo
    );

    datos.append(
    "password",
    password
    );

    datos.append(
    "nombre",
    nombre
    );

    datos.append(
    "accion",
    "registrar"
    );


    // PETICION

    var respuesta =
    await fetch(

    "php/usuario/apiUsuario.php",

    {

        method:"POST",

        body:datos

    }

    );


    var resultado =
    await respuesta.json();

    console.log(resultado);


    if(resultado.success == true){

        Swal.fire({

            icon:"success",

            title:"EXITO!",

            text:
            resultado.mensaje,

            footer:
            "CRUD CONTACTOS"

        });

        document
        .querySelector(
        "#formRegistros"
        )
        .reset();

        setTimeout(()=>{

            window.location.href=
            "index.html";

        },2000);

    }else{

        Swal.fire({

            icon:"error",

            title:"ERROR",

            text:
            resultado.mensaje,

            footer:
            "CRUD CONTACTOS"

        });

    }

}



const loginUsuario = async() => {

    var username =
    document.querySelector(
    "#username"
    ).value;

    var password =
    document.querySelector(
    "#password"
    ).value;


    if(

        username.trim()==='' ||

        password.trim()===''

    ){

        Swal.fire({

            icon:'error',

            title:'ERROR',

            text:
            'FALTA LLENAR CAMPOS',

            footer:
            'CRUD CONTACTO'

        });

        return;

    }


    if(!validarPassword(password)){

        Swal.fire({

            icon:'error',

            title:'ERROR',

            html:
            'FALTA COLOCAR TU PASSWORD <br>[mínimo 8 caracteres]',

            footer:
            'CRUD CONTACTO'

        });

        return;

    }


    const datos =
    new FormData();


    datos.append(
    "username",
    username
    );

    datos.append(
    "password",
    password
    );

    datos.append(
    "accion",
    "login"
    );


    var respuesta =
    await fetch(

    "php/usuario/apiUsuario.php",

    {

        method:'POST',

        body:datos

    }

    );


    var resultado =
    await respuesta.json();


    if(resultado.success==true){

        Swal.fire({

            icon:'success',

            title:'ÉXITO!',

            text:
            resultado.mensaje,

            footer:
            'CRUD CONTACTOS'

        });


        document
        .querySelector(
        "#formLogin"
        )
        .reset();


        localStorage.setItem(

        "nombre",

        resultado.nombre

        );


        setTimeout(()=>{

            window.location.href=
            "inicio.html";

        },2000);

    }else{

        Swal.fire({

            icon:'error',

            title:'ERROR',

            text:
            resultado.mensaje,

            footer:
            'CRUD CONTACTOS'

        });

    }

};