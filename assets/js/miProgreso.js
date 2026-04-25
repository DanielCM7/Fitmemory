document.addEventListener("DOMContentLoaded", function () {
  const dataNode = document.getElementById("miProgresoData");
  const graficaMensual = document.getElementById("graficaMensual");
  const graficaGrupos = document.getElementById("graficaGrupos");

  if (
    !dataNode ||
    !graficaMensual ||
    !graficaGrupos ||
    typeof Chart === "undefined"
  ) {
    return;
  }

  const raw = (dataNode.textContent || "").trim();
  let progresoData;

  if (!raw) {
    console.warn("No hay datos disponibles para mostrar el progreso.");
    return;
  }

  try {
    progresoData = JSON.parse(raw);
  } catch (error) {
    console.error("No se pudieron leer los datos de mi progreso.", error);
    return;
  }

  const chartMeses = progresoData.chartMeses || [];
  const chartSesiones = progresoData.chartSesiones || [];
  const chartVolumen = progresoData.chartVolumen || [];
  const chartGrupos = progresoData.chartGrupos || [];
  const chartGruposVol = progresoData.chartGruposVol || [];

  new Chart(graficaMensual, {
    data: {
      labels: chartMeses,
      datasets: [
        {
          type: "bar",
          label: "Sesiones",
          data: chartSesiones,
          backgroundColor: "rgba(37, 99, 235, 0.55)",
          borderColor: "rgba(37, 99, 235, 0.9)",
          borderWidth: 1,
          yAxisID: "ySesiones",
        },
        {
          type: "line",
          label: "Volumen (kg)",
          data: chartVolumen,
          borderColor: "rgba(14, 165, 233, 0.9)",
          backgroundColor: "rgba(14, 165, 233, 0.12)",
          borderWidth: 2,
          pointRadius: 4,
          tension: 0.3,
          fill: true,
          yAxisID: "yVolumen",
        },
      ],
    },
    options: {
      responsive: true,
      interaction: { mode: "index", intersect: false },
      plugins: {
        legend: { labels: { color: "#e5e7eb" } },
      },
      scales: {
        x: {
          ticks: { color: "#94a3b8" },
          grid: { color: "rgba(255,255,255,0.06)" },
        },
        ySesiones: {
          type: "linear",
          position: "left",
          ticks: { color: "#94a3b8", stepSize: 1 },
          grid: { color: "rgba(255,255,255,0.06)" },
          title: { display: true, text: "Sesiones", color: "#94a3b8" },
        },
        yVolumen: {
          type: "linear",
          position: "right",
          ticks: { color: "#94a3b8" },
          grid: { drawOnChartArea: false },
          title: { display: true, text: "Volumen (kg)", color: "#94a3b8" },
        },
      },
    },
  });

  new Chart(graficaGrupos, {
    type: "bar",
    data: {
      labels: chartGrupos,
      datasets: [
        {
          label: "Volumen (kg)",
          data: chartGruposVol,
          backgroundColor: [
            "rgba(37,99,235,0.6)",
            "rgba(14,165,233,0.6)",
            "rgba(34,197,94,0.6)",
            "rgba(234,179,8,0.6)",
            "rgba(239,68,68,0.6)",
            "rgba(168,85,247,0.6)",
            "rgba(249,115,22,0.6)",
            "rgba(20,184,166,0.6)",
          ],
          borderColor: "rgba(255,255,255,0.15)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      indexAxis: "y",
      responsive: true,
      plugins: {
        legend: { display: false },
      },
      scales: {
        x: {
          ticks: { color: "#94a3b8" },
          grid: { color: "rgba(255,255,255,0.06)" },
          title: { display: true, text: "Volumen (kg)", color: "#94a3b8" },
        },
        y: {
          ticks: { color: "#94a3b8" },
          grid: { color: "rgba(255,255,255,0.06)" },
        },
      },
    },
  });
});
