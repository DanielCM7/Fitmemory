// Fichero JS: actualiza la lista de ejercicios segun el grupo muscular
const ejerciciosPorGrupo = window.ejerciciosPorGrupo || {};

const ejerciciosContainer = document.getElementById("ejerciciosContainer");
const anadirEjercicioBtn = document.getElementById("anadirEjercicio");

function resetEjercicios(select) {
  select.innerHTML =
    '<option value="" disabled selected>Selecciona un ejercicio</option>';
}

function actualizarEjerciciosEnBloque(bloque) {
  const grupoSelect = bloque.querySelector(".grupo-muscular");
  const ejercicioSelect = bloque.querySelector(".ejercicio");

  if (!grupoSelect || !ejercicioSelect) {
    return;
  }

  const grupo = grupoSelect.value;
  const ejercicios = ejerciciosPorGrupo[grupo] || [];

  resetEjercicios(ejercicioSelect);

  ejercicios.forEach(({ id, nombre }) => {
    const option = document.createElement("option");
    option.value = id;
    option.textContent = nombre;
    ejercicioSelect.appendChild(option);
  });
}

function actualizarBotonesEliminar() {
  const bloques = ejerciciosContainer
    ? ejerciciosContainer.querySelectorAll(".ejercicio-item")
    : [];

  bloques.forEach((bloque) => {
    const botonEliminar = bloque.querySelector(".eliminar-ejercicio");

    if (botonEliminar) {
      botonEliminar.disabled = bloques.length === 1;
    }
  });
}

function prepararBloque(bloque) {
  const grupoSelect = bloque.querySelector(".grupo-muscular");
  const botonEliminar = bloque.querySelector(".eliminar-ejercicio");

  if (grupoSelect) {
    grupoSelect.addEventListener("change", () => actualizarEjerciciosEnBloque(bloque));
  }

  if (botonEliminar) {
    botonEliminar.addEventListener("click", () => {
      const bloques = ejerciciosContainer.querySelectorAll(".ejercicio-item");

      if (bloques.length === 1) {
        return;
      }

      bloque.remove();
      actualizarBotonesEliminar();
    });
  }
}

if (ejerciciosContainer) {
  const primerBloque = ejerciciosContainer.querySelector(".ejercicio-item");

  if (primerBloque) {
    prepararBloque(primerBloque);
    actualizarBotonesEliminar();
  }
}

if (anadirEjercicioBtn && ejerciciosContainer) {
  anadirEjercicioBtn.addEventListener("click", () => {
    const bloqueBase = ejerciciosContainer.querySelector(".ejercicio-item");

    if (!bloqueBase) {
      return;
    }

    const nuevoBloque = bloqueBase.cloneNode(true);

    nuevoBloque.querySelectorAll("input").forEach((input) => {
      if (input.name === "descanso[]" || input.name === "rpe[]") {
        input.value = "0";
      } else {
        input.value = "";
      }
    });

    nuevoBloque.querySelectorAll("select").forEach((select) => {
      select.selectedIndex = 0;

      if (select.classList.contains("ejercicio")) {
        resetEjercicios(select);
      }
    });

    ejerciciosContainer.appendChild(nuevoBloque);
    prepararBloque(nuevoBloque);
    actualizarBotonesEliminar();
  });
}
