var sesion = localStorage.getItem("nombre");

const checarSesion = () => {

    if(sesion == null){

        window.location.href = "index.html";

    }

    document.querySelector(
    "#usuario"
    ).innerHTML = sesion;

}


const cerrarSesion = () => {

    localStorage.clear();

    window.location.href =
    "index.html";

}


// AGREGAR

const agregarContacto =
async() => {

    var nombre =
    document.querySelector(
    "#nombre"
    ).value;

    var ap =
    document.querySelector(
    "#ap"
    ).value;

    var am =
    document.querySelector(
    "#am"
    ).value;

    var telefono =
    document.querySelector(
    "#telefono"
    ).value;

    var correo =
    document.querySelector(
    "#correo"
    ).value;


    if(

    nombre.trim()=='' ||

    ap.trim()=='' ||

    am.trim()=='' ||

    telefono.trim()=='' ||

    correo.trim()==''

    ){

        Swal.fire({

            icon:'error',

            title:'ERROR',

            text:
            'FALTA LLENAR CAMPOS'

        });

        return;

    }


    const datos =
    new FormData();


    datos.append(
    "nombre",
    nombre
    );

    datos.append(
    "ap",
    ap
    );

    datos.append(
    "am",
    am
    );

    datos.append(
    "telefono",
    telefono
    );

    datos.append(
    "correo",
    correo
    );

    datos.append(
    "accion",
    "agregar"
    );


    var respuesta =
    await fetch(

    "php/contactos/apiContacto.php",

    {

        method:"POST",

        body:datos

    }

    );


    var resultado =
    await respuesta.json();


    if(resultado.success){

        Swal.fire({

            icon:'success',

            title:'EXITO',

            text:
            resultado.mensaje

        });

        document
        .querySelector(
        "#formAgregar"
        )
        .reset();


        cargarContactos();

    }

}



// CARGAR TODOS

const cargarContactos =
async() => {

    const datos =
    new FormData();

    datos.append(
    "accion",
    "cargarTodo"
    );


    var respuesta =
    await fetch(

    "php/contactos/apiContacto.php",

    {

        method:"POST",

        body:datos

    }

    );


    var resultado =
    await respuesta.json();


    var registrosHTML='';


    resultado.data
    .forEach(
    fila=>{

        registrosHTML += `

        <tr>

        <td>${fila[1]}</td>

        <td>${fila[2]}</td>

        <td>${fila[3]}</td>

        <td>${fila[4]}</td>

        <td>${fila[5]}</td>


        <td>

        <button

        class="btn btn-success"

        onclick=
        "cargarContacto(
        ${fila[0]}
        )"

        data-bs-toggle=
        "modal"

        data-bs-target=
        "#editarModal"

        >

        Editar

        </button>

        </td>


        <td>

        <button

        class=
        "btn btn-danger"

        onclick=
        "eliminarContacto(
        ${fila[0]}
        )"

        >

        Eliminar

        </button>

        </td>

        </tr>

        `;

    });


    document
    .querySelector(
    "#registros"
    )
    .innerHTML=
    registrosHTML;

}



// CARGAR UNO

const cargarContacto =
async(contactoId)=>{

    const datos =
    new FormData();


    datos.append(
    "contactoId",
    contactoId
    );

    datos.append(
    "accion",
    "cargar"
    );


    var respuesta =
    await fetch(

    "php/contactos/apiContacto.php",

    {

        method:"POST",

        body:datos

    }

    );


    var resultado =
    await respuesta.json();


    if(resultado.success){

        document
        .querySelector(
        "#contactoIdEditar"
        )
        .value=
        resultado.contactoid;


        document
        .querySelector(
        "#enombre"
        )
        .value=
        resultado.nombre;


        document
        .querySelector(
        "#eap"
        )
        .value=
        resultado.ap;


        document
        .querySelector(
        "#eam"
        )
        .value=
        resultado.am;


        document
        .querySelector(
        "#etelefono"
        )
        .value=
        resultado.telefono;


        document
        .querySelector(
        "#ecorreo"
        )
        .value=
        resultado.correo;

    }

}



// EDITAR

const editarContacto =
async()=>{

    var contactoId =
    document.querySelector(
    "#contactoIdEditar"
    ).value;


    var nombre =
    document.querySelector(
    "#enombre"
    ).value;


    var ap =
    document.querySelector(
    "#eap"
    ).value;


    var am =
    document.querySelector(
    "#eam"
    ).value;


    var telefono =
    document.querySelector(
    "#etelefono"
    ).value;


    var correo =
    document.querySelector(
    "#ecorreo"
    ).value;


    const datos =
    new FormData();


    datos.append(
    "contactoId",
    contactoId
    );

    datos.append(
    "nombre",
    nombre
    );

    datos.append(
    "ap",
    ap
    );

    datos.append(
    "am",
    am
    );

    datos.append(
    "telefono",
    telefono
    );

    datos.append(
    "correo",
    correo
    );

    datos.append(
    "accion",
    "editar"
    );


    var respuesta =
    await fetch(

    "php/contactos/apiContacto.php",

    {

        method:'POST',

        body:datos

    }

    );


    var resultado =
    await respuesta.json();


    if(resultado.success){

        Swal.fire({

            icon:'success',

            title:'EXITO',

            text:
            resultado.mensaje

        });


        cargarContactos();


        document
        .querySelector(
        "#formEditar"
        )
        .reset();


        var modal =

        bootstrap.Modal
        .getInstance(

        document
        .getElementById(
        'editarModal'
        )

        );


        modal.hide();

    }

}



// ELIMINAR

const eliminarContacto =
(contactoId)=>{

    Swal.fire({

        title:
        '¿Estás seguro de eliminar este Contacto?',

        showDenyButton:true,

        confirmButtonText:'SI',

        denyButtonText:'NO'

    })

    .then(

    async(result)=>{

    if(
    result.isConfirmed
    ){

        const datos =
        new FormData();


        datos.append(
        "contactoId",
        contactoId
        );

        datos.append(
        "accion",
        "eliminar"
        );


        var respuesta =
        await fetch(

        "php/contactos/apiContacto.php",

        {

            method:"POST",

            body:datos

        }

        );


        var resultado =
        await respuesta.json();


        if(
        resultado.success
        ){

            Swal.fire({

                icon:'success',

                title:'EXITO',

                text:
                resultado.mensaje

            });

        }


        cargarContactos();

    }

    });

}