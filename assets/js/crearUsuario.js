// Procesamos el formulario en JavaScript antes de procesarlo con PHP

// Desactivamos el corrector ortográfico del navegador
document.querySelectorAll('#formCrearUsuario input')
        .forEach(el => el.setAttribute('spellcheck', 'false'));

// Guardamos en una variable el formulario y los nodos input
let formulario = document.getElementById('formCrearUsuario');
let usuario = document.getElementById("idUsuario");
let nombre = document.getElementById("idNombre");
let apellidos = document.getElementById("idApellidos");
let fechaNac = document.getElementById("idFechaNac");
let perfil = document.getElementById("idPerfil");
let contrasena = document.getElementById("idPassword");
let email = document.getElementById("idEmail");

// JavaScript para saber la fecha actual _________________________________
let hoy = new Date();
// Pasar fecha de hoy a formato yyyy-mm-dd
function getFechaActual() {
    const year = hoy.getFullYear();
    const month = String(hoy.getMonth() + 1).padStart(2, '0');
    const day = String(hoy.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}
// Fecha actual
let fechaActual = getFechaActual();

//Límite máximo fecha seleccionable
document.getElementById('idFechaNac').setAttribute('max', fechaActual);


// PATRONES REGEX __________________________________________________

// El usuario tiene que tener entre 3 y 20 caracteres, sin caracteres especiales ni espacios, permite guiones y caracteres alfanuméricos
const usuarioRegex = /^[a-zA-Z0-9_-]{3,20}$/;
// Entre 2 y 40 o 60 caracteres no numéricos, sólo letras y espacios y tildes españolas
const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,40}$/;
const apellidosRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,60}$/;
// Longitud mínima de 8 caracteres, al menos una mayúscula, número y caracter especial
const contrasenaRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$/;
// Array con los perfiles válidos
const perfilesValidos = ["Entrenador", "Cliente"];
// uno o más caracteres que no sean @ ni espacio, @, uno o más caracteres de nuevo, punto, y uno o más caracteres
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


// DATOS LIMITACIÓN EDAD ___________________________________________
const edadMinima = 16;
// Calcular fecha mínima para tener edad Mínima
const fechaMinimaNacimiento = new Date(
    hoy.getFullYear() - edadMinima,
    hoy.getMonth(),
    hoy.getDate()
);


// Función para escribir un mensaje de error asociado a un input específico y modificar la clase
function setError(nodo, mensaje) {
    const nodoInput = nodo.parentElement;
    const errorDisplay = nodoInput.querySelector('.error');

    errorDisplay.innerText = mensaje;
    nodoInput.classList.add('error');
    nodoInput.classList.remove('exito')
}

// Función para mostrar que el input es válido
function setExito(nodo) {
    const nodoInput = nodo.parentElement;
    const errorDisplay = nodoInput.querySelector('.error');

    errorDisplay.innerText = '';
    nodoInput.classList.add('exito');
    nodoInput.classList.remove('error');
};

// EVENTO JS AL HACER SUBMIT (ENVIAR) ________________________________
formulario.addEventListener('submit', e => {

// Evitar recarga
e.preventDefault();
// validez
let valido = true;

// Vamos a crear una variable por cada elemento del formulario y obtener el valor introducido con un trim() que elimine espacios en blanco por delante y por detrás
let usuarioValue = usuario.value.trim();
let nombreValue = nombre.value.trim();
let apellidosValue = apellidos.value.trim();
let fechaNacValue = fechaNac.value;
let perfilValue = perfil.value;
let contrasenaValue = contrasena.value;
let emailValue = email.value.trim();

// CONDICIONES DE VALIDACIÓN

    if (perfil != "administrador") {
        if(perfilesValidos.includes(perfilValue)) {
            setExito(perfil);
        } else {
            setError(perfil, 'El perfil debe ser entrenador o cliente');
            valido = false;
        }
    }

    if(usuarioValue === '') {
        setError(usuario, 'El campo de usuario no puede estar vacío');
        valido = false;
    } else if(!usuarioRegex.test(usuarioValue)) {
        setError(usuario, 'Este nombre de usuario no es válido');
        valido = false;
    } else {
        setExito(usuario);
    }

    if(nombreValue === '') {
        setError(nombre, 'El campo de nombre no puede estar vacío');
        valido = false;
    } else if (!nombreRegex.test(nombreValue)) {
        setError(nombre, 'El nombre no es válido. Revise que no este usando caracteres especiales o digitos.');
        valido = false;
    } else {
        setExito(nombre);
    }

    if(apellidosValue === '') {
        setError(apellidos, 'El campo de apellidos no puede estar vacío');
        valido = false;
    } else if (!apellidosRegex.test(apellidosValue)) {
        setError(apellidos, 'Los apellidos no son válidos. Revise que no este usando caracteres especiales o digitos.');
        valido = false;
    } else {
        setExito(apellidos);
    }

     if(contrasenaValue === '') {
        setError(contrasena, 'El campo de contraseña no puede estar vacío');
        valido = false;
    } else if (!contrasenaRegex.test(contrasenaValue)) {
        setError(contrasena, 'La contraseña no es válida. Debe tener mínimo 8 caracteres, entre ellos una mayúscula, un número y un caracter no alfanumérico.');
        valido = false;
    } else {
        setExito(contrasena);
    }

     if(fechaNacValue === '') {
        setError(fechaNac, 'La fecha de nacimiento no puede quedar vacía');
        valido = false;
    } else if (new Date(fechaNacValue) > fechaMinimaNacimiento) {
        setError(fechaNac, `Debes haber cumplido al menos ${edadMinima} para ser usuario de esta aplicación.`);
        valido = false;
    } else {
        setExito(fechaNac);
    }

    if(emailValue === '') {
        setError(email, 'El campo de correo electrónico no puede quedar vacío');
        valido = false;
    } else if (!emailRegex.test(emailValue)) {
        setError(email, 'Formato de correo electrónico inválido');
        valido = false;
    } else {
        setExito(email);
    }

    // Si después de todas las comprobaciones la variable valido sigue siendo true, se envía a validar en php
    if(valido) {
        formulario.submit();
    }
});