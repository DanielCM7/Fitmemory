document.addEventListener("DOMContentLoaded", function () {
  const inputFecha = document.getElementById("filtroFecha");
  const mensajeInicial = document.getElementById("mensajeInicial");
  const sinSesiones = document.getElementById("sinSesiones");
  const articulos = document.querySelectorAll("#sesionesContainer article");

  function filtrarSesiones(fecha) {
    if (mensajeInicial) {
      mensajeInicial.style.display = fecha ? "none" : "";
    }

    let encontradas = 0;

    articulos.forEach(function (art) {
      if (fecha && art.dataset.fecha === fecha) {
        art.style.display = "";
        encontradas++;
      } else {
        art.style.display = "none";
      }
    });

    if (sinSesiones) {
      sinSesiones.style.display = fecha && encontradas === 0 ? "" : "none";
    }
  }

  flatpickr(inputFecha, {
    locale: "es",
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
    disableMobile: true,
    allowInput: false,
    position: "auto center",
    onChange: function (selectedDates, dateStr) {
      filtrarSesiones(dateStr);
    },
  });

  filtrarSesiones("");
});
