
/* VARIABLES Y CONSTANTES________________________________________________________ */

const tabla = document.getElementById("tabla");

//SE PUIEDEN AÑADIR BOTONES LA TABLA DESDE AQUÍ
const tiposBt = [
                {
                    contenido: "ACTUALIZAR",
                    class: "bi-pencil-square"
                },
                {
                    contenido: "ELIMINAR",
                    class: "bi-trash"
                }];


/* FUNCIONES ______________________________________________________________________ */
//Genera cualquier tabla apartir de datos de la BD pasados a JSON
function generarTabla(datosTabla) {

    // CABEZA Y CUERPO DE LA TABLA (IMPORTANTE o no se aplica CSS Bootstrap)
    let thead = document.createElement("thead");
    tabla.appendChild(thead);
    let tbody = document.createElement("tbody");
    tabla.appendChild(tbody);

    if (!Array.isArray(datosTabla) || datosTabla.length === 0 || !datosTabla[0] ||
    Object.keys(datosTabla[0]).length === 0) {
        let fila = document.createElement("tr");
        let campo = document.createElement("td");
        campo.colSpan = 1;
        campo.style.textAlign = "center";
        campo.textContent = "ERROR: No se han encontrado los datos";
        fila.appendChild(campo);
        tbody.appendChild(fila);

    } else {
        // CREACIÓN CABECERA
        let filaCabecera = document.createElement("tr");
        let columnas = Object.keys(datosTabla[0]);

        columnas.forEach(columna => {
            let cabecera = document.createElement("th");
            cabecera.textContent = columna;
            filaCabecera.appendChild(cabecera);
        });
        tiposBt.forEach(tipo => {
                let cabeceraBt = document.createElement("th");
                cabeceraBt.textContent = tipo.contenido;
                filaCabecera.appendChild(cabeceraBt);
            });
        thead.appendChild(filaCabecera);

        // CREACION BODY TABLA
        datosTabla.forEach(dato => {
            let fila = document.createElement("tr");

            // Celdas visibles
            columnas.forEach(columna => {
                let campo = document.createElement("td");

                campo.textContent = (columna === "contrasena_hash") ? "******" : dato[columna];

                fila.appendChild(campo);
            });

            // BOTONES CON FORMULARIOS
            tiposBt.forEach(tipo => {
                let campo = document.createElement("td");
                campo.style.textAlign = "center";

                let formulario = document.createElement("form");
                formulario.style.margin = "0px";
                formulario.method = "POST";

                // Inputs formulario ACTUALIZAR
                if (tipo.contenido == "ACTUALIZAR"){
                    columnas.forEach(columna => {
                        let input = document.createElement("input");
                        input.type = "hidden";
                        input.name = columna;
                        input.value = dato[columna];
                        input.formAction = "index.php?vista=adminActualizarUsuario";
                        formulario.appendChild(input);
                    });
                }
                // Inputs ELIMINAR
                if (tipo.contenido == "ELIMINAR") {
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "id";
                    input.value = dato[columnas[0]];
                    formulario.appendChild(input)
                }

                // Acción
                let inputAccion = document.createElement("input");
                inputAccion.type = "hidden";
                inputAccion.name = "accion";
                inputAccion.value = tipo.contenido.toLowerCase();
                formulario.appendChild(inputAccion);

                // Botón
                let bt = document.createElement("button");
                bt.type = "submit";
                bt.classList.add("btn", "btn-outline-light", "btFormAdmin");

                if (tipo.contenido == "ACTUALIZAR") {
                    bt.formAction = "index.php?vista=adminActualizarUsuario";
                }
                if (tipo.contenido == "ELIMINAR") {
                    bt.addEventListener('click', () => {
                        window.location.reload();
                    });
                }

                let icono = document.createElement("i");
                icono.classList.add("bi", tipo.class);

                bt.appendChild(icono);
                formulario.appendChild(bt);

                campo.appendChild(formulario);
                fila.appendChild(campo);
            });

            tbody.appendChild(fila);
        });
    }
}

/* FUNCIONES   ____________________________________________________________________*/

// Función que permite filtrar usuarios según un input
function filtrarUsuarios() {
  // Variable que recoge el valor del campo de texto del buscador
  let texto = document.getElementById("buscador").value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  // Variable que guardará todas las filas de la tabla a filtrar
  let filas = document.querySelectorAll("tr");
  // Por cada fila cambiamos su visibilidad dependiendo de si contiene el filtro
  filas.forEach((fila, index) => {
    // Nos saltamos el primer tr, ya que es el de la cabecera (th)
    if (index === 0) return;
    // Almacenamos el contenido de cada fila
    let contenido = fila.textContent.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    if (contenido.includes(texto)) {
      fila.style.display = "table-row";
    } else {
      fila.style.display = "none";
    }
  });
}



/* PROCESAMIENTO __________________________________________________________________ */

// Indicamos que al modificar el input del campo de texto con id filtro, se accione filtrarUsuarios

document.getElementById("buscador").addEventListener("input", filtrarUsuarios);