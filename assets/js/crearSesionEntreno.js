document.addEventListener("DOMContentLoaded", function () {
  flatpickr("#fecha", {
    locale: "es",
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
    disableMobile: true,
    allowInput: false,
    defaultDate: document.getElementById("fecha").value || new Date(),
  });
});
