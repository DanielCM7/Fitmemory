// FICHERO JS: Script para actualizar la lista de ejercicios según el grupo muscular seleccionado
//  en el formulario de creación de sesión de entrenamiento
const ejerciciosPorGrupo = window.ejerciciosPorGrupo || {};

const grupoSelect = document.getElementById("grupoMuscular");
const ejercicioSelect = document.getElementById("ejercicio");

function actualizarEjercicios() {
  const grupo = grupoSelect.value;
  const ejercicios = ejerciciosPorGrupo[grupo] || [];

  ejercicioSelect.innerHTML =
    '<option value="" disabled selected>Selecciona un ejercicio</option>';

  ejercicios.forEach((nombre) => {
    const option = document.createElement("option");
    option.value = nombre;
    option.textContent = nombre;
    ejercicioSelect.appendChild(option);
  });
}

if (grupoSelect && ejercicioSelect) {
  grupoSelect.addEventListener("change", actualizarEjercicios);
}
