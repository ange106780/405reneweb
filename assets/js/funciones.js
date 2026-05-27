const validarCorreo = (correo) => {
    return /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(correo.trim());
}

const validarPassword = (password) => {
    return /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}/.test(password.trim());
}

const validarNombre = (nombre) => {
    return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,60}$/.test(nombre.trim());
}