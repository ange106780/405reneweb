var sesion = localStorage.getItem("nombre");

// =======================
// SESION
// =======================
const checarSesion = () => {
    if(sesion == null){
        window.location.href = "index.html";
    }

    if(document.querySelector("#usuario")){
        document.querySelector("#usuario").innerHTML = sesion;
    }
}

const cerrarSesion = () => {
    localStorage.clear();
    window.location.href = "index.html";
}

// =======================
// REGISTRAR USUARIO
// =======================
const registrarUsuario = async() => {
    var correo = document.querySelector("#correo").value;
    var password = document.querySelector("#password").value;
    var nombre = document.querySelector("#nombre").value;

    if(correo.trim()==='' || password.trim()==='' || nombre.trim()===''){
        Swal.fire({
            icon:'error',
            title:'ERROR',
            text:'FALTA LLENAR CAMPOS'
        });
        return;
    }

    const datos = new FormData();
    datos.append("correo", correo);
    datos.append("password", password);
    datos.append("nombre", nombre);
    datos.append("accion", "registrar");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var texto = await respuesta.text();
    console.log(texto);
    var resultado = JSON.parse(texto);

    if(resultado.success){
        Swal.fire({
            icon:'success',
            title:'EXITO',
            text: resultado.mensaje
        });

        document.querySelector("#formRegistros").reset();

        setTimeout(()=>{
            window.location.href = "index.html";
        },2000);
    }else{
        Swal.fire({
            icon:'error',
            title:'ERROR',
            text: resultado.mensaje
        });
    }
}

// =======================
// LOGIN
// =======================
const loginUsuario = async() => {
    var username = document.querySelector("#username").value;
    var password = document.querySelector("#password").value;

    if(username.trim()==='' || password.trim()===''){
        Swal.fire({
            icon:'error',
            title:'ERROR',
            text:'FALTA LLENAR CAMPOS'
        });
        return;
    }

    const datos = new FormData();
    datos.append("username", username);
    datos.append("password", password);
    datos.append("accion", "login");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();

    if(resultado.success){
        Swal.fire({
            icon:'success',
            title:'EXITO',
            text: resultado.mensaje
        });

        localStorage.setItem("nombre", resultado.nombre);
        document.querySelector("#formLogin").reset();

        setTimeout(()=>{
            window.location.href = "inicio.html";
        },2000);
    }else{
        Swal.fire({
            icon:'error',
            title:'ERROR',
            text: resultado.mensaje
        });
    }
}

// =======================
// AGREGAR CONTACTO
// =======================
const agregarContacto = async() => {
    var nombre = document.querySelector("#nombre").value;
    var ap = document.querySelector("#ap").value;
    var am = document.querySelector("#am").value;
    var telefono = document.querySelector("#telefono").value;
    var correo = document.querySelector("#correo").value;

    const datos = new FormData();
    datos.append("nombre", nombre);
    datos.append("ap", ap);
    datos.append("am", am);
    datos.append("telefono", telefono);
    datos.append("correo", correo);
    datos.append("accion", "agregar");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();

    if(resultado.success){
        Swal.fire({
            icon:'success',
            title:'EXITO',
            text: resultado.mensaje
        });
        cargarContactos();
        document.querySelector("#formAgregar").reset();
    }
}

// =======================
// CARGAR CONTACTOS
// =======================
const cargarContactos = async() => {
    const datos = new FormData();
    datos.append("accion", "cargarTodo");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();
    var registrosHTML='';

    resultado.data.forEach(fila=>{
        registrosHTML += `
        <tr>
            <td>${fila[1]}</td>
            <td>${fila[2]}</td>
            <td>${fila[3]}</td>
            <td>${fila[4]}</td>
            <td>${fila[5]}</td>
            <td>
                <button class="btn btn-success" onclick="cargarContacto(${fila[0]})" data-bs-toggle="modal" data-bs-target="#editarModal">Editar</button>
            </td>
            <td>
                <button class="btn btn-danger" onclick="eliminarContacto(${fila[0]})">Eliminar</button>
            </td>
        </tr>
        `;
    });

    document.querySelector("#registros").innerHTML = registrosHTML;
}

// =======================
// CARGAR CONTACTO
// =======================
const cargarContacto = async(contactoId)=>{
    const datos = new FormData();
    datos.append("contactoId", contactoId);
    datos.append("accion", "cargar");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();

    if(resultado.success){
        document.querySelector("#contactoIdEditar").value = resultado.contactoId;
        document.querySelector("#enombre").value = resultado.nombre;
        document.querySelector("#eap").value = resultado.ap;
        document.querySelector("#eam").value = resultado.am;
        document.querySelector("#etelefono").value = resultado.telefono;
        document.querySelector("#ecorreo").value = resultado.correo;
    }
}

// =======================
// EDITAR CONTACTO
// =======================
const editarContacto = async()=>{
    const datos = new FormData();
    datos.append("accion", "editar");
    datos.append("contactoId", document.querySelector("#contactoIdEditar").value);
    datos.append("nombre", document.querySelector("#enombre").value);
    datos.append("ap", document.querySelector("#eap").value);
    datos.append("am", document.querySelector("#eam").value);
    datos.append("telefono", document.querySelector("#etelefono").value);
    datos.append("correo", document.querySelector("#ecorreo").value);

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();

    if(resultado.success){
        Swal.fire({
            icon:'success',
            title:'EXITO',
            text: resultado.mensaje
        });
        cargarContactos();
    }
}

// =======================
// ELIMINAR CONTACTO
// =======================
const eliminarContacto = (contactoId)=>{
    Swal.fire({
        title: '¿Eliminar contacto?',
        showDenyButton:true,
        confirmButtonText:'SI',
        denyButtonText:'NO'
    })
    .then(async(result)=>{
        if(result.isConfirmed){
            const datos = new FormData();
            datos.append("contactoId", contactoId);
            datos.append("accion", "eliminar");

            var respuesta = await fetch("php/apiSistema.php", {
                method:"POST",
                body:datos
            });

            var resultado = await respuesta.json();

            if(resultado.success){
                Swal.fire({
                    icon:'success',
                    title:'EXITO',
                    text: resultado.mensaje
                });
                cargarContactos();
            }
        }
    });
}

// ========================
// CARGAR CITAS
// ========================
const cargarCitas = async() => {
    const datos = new FormData();
    datos.append("accion", "cargarCitas");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();
    var registrosHTML = '';

    resultado.data.forEach(fila=>{
        registrosHTML += `
        <tr>
            <td>${fila.titulo}</td>
            <td>${fila.descripcion}</td>
            <td>${fila.fecha}</td>
            <td>${fila.hora}</td>
            <td>${fila.lugar}</td>
            <td>${fila.estado}</td>
            <td>
                <button class="btn btn-success" onclick="cargarCita(${fila.citaId})" data-bs-toggle="modal" data-bs-target="#editarModal">Editar</button>
            </td>
            <td>
                <button class="btn btn-danger" onclick="eliminarCita(${fila.citaId})">Eliminar</button>
            </td>
        </tr>
        `;
    });

    document.querySelector("#registros").innerHTML = registrosHTML;
}

// ========================
// AGREGAR CITA
// ========================
const agregarCita = async()=>{
    const datos = new FormData();
    datos.append("titulo", document.querySelector("#titulo").value);
    datos.append("descripcion", document.querySelector("#descripcion").value);
    datos.append("fecha", document.querySelector("#fecha").value);
    datos.append("hora", document.querySelector("#hora").value);
    datos.append("lugar", document.querySelector("#lugar").value);
    datos.append("estado", document.querySelector("#estado").value);
    datos.append("contactoId", document.querySelector("#contactoId").value);
    datos.append("accion", "agregarCita");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();

    if(resultado.success){
        Swal.fire({
            icon:'success',
            title:'EXITO',
            text:resultado.mensaje
        });

        cargarCitas();
        document.querySelector("#formAgregarCita").reset();

        const modalAgregar = bootstrap.Modal.getInstance(document.querySelector('#agregarModal'));
        if(modalAgregar) modalAgregar.hide();
    } else {
        Swal.fire({
            icon:'error',
            title:'ERROR',
            text:resultado.mensaje
        });
    }
}

// ========================
// CARGAR UNA CITA
// ========================
const cargarCita = async(citaId)=>{
    const datos = new FormData();
    datos.append("citaId", citaId);
    datos.append("accion", "cargarCita");

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();

    if(resultado.success){
        document.querySelector("#ecitaId").value = resultado.citaId;
        document.querySelector("#etitulo").value = resultado.titulo;
        document.querySelector("#edescripcion").value = resultado.descripcion;
        document.querySelector("#efecha").value = resultado.fecha;
        document.querySelector("#ehora").value = resultado.hora;
        document.querySelector("#elugar").value = resultado.lugar;
        document.querySelector("#eestado").value = resultado.estado;
    }
}

// ========================
// EDITAR CITA
// ========================
const editarCita = async()=>{
    const datos = new FormData();
    datos.append("accion", "editarCita");
    datos.append("citaId", document.querySelector("#ecitaId").value);
    datos.append("titulo", document.querySelector("#etitulo").value);
    datos.append("descripcion", document.querySelector("#edescripcion").value);
    datos.append("fecha", document.querySelector("#efecha").value);
    datos.append("hora", document.querySelector("#ehora").value);
    datos.append("lugar", document.querySelector("#elugar").value);
    datos.append("estado", document.querySelector("#eestado").value);

    var respuesta = await fetch("php/apiSistema.php", {
        method:"POST",
        body:datos
    });

    var resultado = await respuesta.json();

    if(resultado.success){
        Swal.fire({
            icon:'success',
            title:'EXITO',
            text:resultado.mensaje
        });

        cargarCitas();

        const modalEditar = bootstrap.Modal.getInstance(document.querySelector('#editarModal'));
        if(modalEditar) modalEditar.hide();
    }
}

// ========================
// ELIMINAR CITA
// ========================
const eliminarCita = (citaId)=>{
    Swal.fire({
        title:'¿Eliminar cita?',
        showDenyButton:true,
        confirmButtonText:'SI',
        denyButtonText:'NO'
    })
    .then(async(result)=>{
        if(result.isConfirmed){
            const datos = new FormData();
            datos.append("citaId", citaId);
            datos.append("accion", "eliminarCita");

            var respuesta = await fetch("php/apiSistema.php", {
                method:"POST",
                body:datos
            });

            var resultado = await respuesta.json();

            if(resultado.success){
                Swal.fire({
                    icon:'success',
                    title:'EXITO',
                    text:resultado.mensaje
                });
                
                cargarCitas();
            }
        }
    });
}