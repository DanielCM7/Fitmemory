document.addEventListener("DOMContentLoaded", function () {
  const inputFecha = document.getElementById("fechaNac");
  if (!inputFecha || typeof window.initFitmemoryDatepicker !== "function") {
    return;
  }

  const fechaRaw = (inputFecha.value || "").trim();
  const fechaIso = /^\d{4}-\d{2}-\d{2}/.test(fechaRaw)
    ? fechaRaw.slice(0, 10)
    : null;

  window.initFitmemoryDatepicker(inputFecha, {
    defaultDate: fechaIso,
    startDate: fechaIso || "1990-01-01",
    minDate: "1900-01-01",
    maxDate: new Date(),
    disableNavWhenOutOfRange: false,
    position: "auto center",
  });
});
