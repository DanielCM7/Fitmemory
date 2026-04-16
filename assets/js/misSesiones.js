document.addEventListener("DOMContentLoaded", function () {
  const inputFecha = document.getElementById("filtroFecha");
  if (!inputFecha || typeof window.initFitmemoryDatepicker !== "function") {
    return;
  }

  const mensajeInicial = document.getElementById("mensajeInicial");
  const sinSesiones = document.getElementById("sinSesiones");
  const limpiarFiltro = document.getElementById("limpiarFiltroFecha");
  const articulos = Array.from(
    document.querySelectorAll("#sesionesContainer article"),
  );
  const fechasDisponibles = articulos
    .map(function (articulo) {
      return articulo.dataset.fecha || "";
    })
    .filter(Boolean);

  const aniosDisponibles = fechasDisponibles.map(function (fecha) {
    return Number.parseInt(fecha.slice(0, 4), 10);
  });

  const yearBounds = aniosDisponibles.length
    ? {
        min: Math.min.apply(null, aniosDisponibles),
        max: Math.max.apply(null, aniosDisponibles),
      }
    : {
        min: new Date().getFullYear(),
        max: new Date().getFullYear(),
      };

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

  if (!fechasDisponibles.length) {
    inputFecha.disabled = true;
    inputFecha.placeholder = "No hay fechas disponibles";

    if (mensajeInicial) {
      mensajeInicial.textContent = "Todavia no tienes sesiones registradas.";
      mensajeInicial.style.display = "";
    }

    if (sinSesiones) {
      sinSesiones.style.display = "";
    }

    if (limpiarFiltro) {
      limpiarFiltro.disabled = true;
    }

    return;
  }

  const selectorFecha = window.initFitmemoryDatepicker(inputFecha, {
    altInputClass: "mis-sesiones-input",
    enable: fechasDisponibles,
    position: "auto center",
    yearBounds: yearBounds,
    onChange: function (selectedDates, dateStr) {
      filtrarSesiones(dateStr);
    },
  });

  if (limpiarFiltro && selectorFecha) {
    limpiarFiltro.addEventListener("click", function () {
      selectorFecha.clear();
      filtrarSesiones("");
    });
  }

  filtrarSesiones("");
});
