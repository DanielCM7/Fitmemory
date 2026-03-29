<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: " . BASE_URL . "/index.php?vista=inicio");
    exit();
}

$gruposMusculares = ["Pecho", "Espalda", "Piernas", "Hombros", "Brazos", "Abdominales"];

$ejerciciosPorGrupo = [
    "Pecho" => ["Press banca", "Press inclinado", "Aperturas"],
    "Espalda" => ["Dominadas", "Remo con barra", "Jalon al pecho"],
    "Piernas" => ["Sentadilla", "Prensa", "Peso muerto rumano"],
    "Hombros" => ["Press militar", "Elevaciones laterales", "Pajaros"],
    "Brazos" => ["Curl biceps", "Fondos triceps", "Curl martillo"],
    "Abdominales" => ["Crunch", "Elevacion de piernas", "Plancha"]
];

?>

<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fitmemory - Nueva Sesión</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
  <main class="app-main w-100 m-auto">
    <?php include "incl/header.php"; ?>

    <form action="procesarSesion.php" method="POST" class="panel-formulario">
      <div class="row mb-3 align-items-center formulario-fila">
        <label for="fecha" class="col-sm-4 col-form-label text-start formulario-label">DIA DE ENTRENO:</label>
        <div class="col-sm-8">
          <input type="date" id="fecha" name="fecha" class="form-control formulario-campo" required />
        </div>
      </div>

      <div class="row mb-3 align-items-center formulario-fila">
        <label for="grupoMuscular" class="col-sm-4 col-form-label text-start formulario-label">GRUPO MUSCULAR:</label>
        <div class="col-sm-8">
          <select id="grupoMuscular" name="grupoMuscular" class="form-control formulario-campo" required>
            <option value="" disabled selected>Selecciona un grupo muscular</option>
            <?php foreach ($gruposMusculares as $grupo): ?>
              <option value="<?php echo htmlspecialchars($grupo); ?>"><?php echo htmlspecialchars($grupo); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="row mb-3 align-items-center formulario-fila">
        <label for="ejercicio" class="col-sm-4 col-form-label text-start formulario-label">EJERCICIO:</label>
        <div class="col-sm-8">
          <select id="ejercicio" name="ejercicio" class="form-control formulario-campo" required>
            <option value="" disabled selected>Selecciona un ejercicio</option>
          </select>
        </div>
      </div>

      <div class="row mb-3 align-items-center formulario-fila">
        <label for="peso" class="col-sm-4 col-form-label text-start formulario-label">PESO (kg):</label>
        <div class="col-sm-8">
          <input type="number" id="peso" name="peso" class="form-control formulario-campo" required />
        </div>
      </div>

      <div class="row mb-3 align-items-center formulario-fila">
        <label for="repeticiones" class="col-sm-4 col-form-label text-start formulario-label">REPETICIONES:</label>
        <div class="col-sm-8">
          <input type="number" id="repeticiones" name="repeticiones" class="form-control formulario-campo" required />
        </div>
      </div>

      <div class="row mb-3 align-items-center formulario-fila">
        <label for="series" class="col-sm-4 col-form-label text-start formulario-label">SERIES:</label>
        <div class="col-sm-8">
          <input type="number" id="series" name="series" class="form-control formulario-campo" required />
        </div>
      </div>

      <div class="row mb-3 align-items-center formulario-fila">
        <label for="descripcion" class="col-sm-4 col-form-label text-start formulario-label">DESCRIPCION:</label>
        <div class="col-sm-8">
          <textarea id="descripcion" name="descripcion" rows="4" class="form-control formulario-campo" required></textarea>
        </div>
      </div>

      <div class="acciones-formulario-centro">
        <button class="btn btn-primary btn-lg boton-principal" type="submit">
          Crear Sesion
        </button>
      </div>
    </form>
  </main>

  <script>
    window.ejerciciosPorGrupo = <?php echo json_encode($ejerciciosPorGrupo, JSON_UNESCAPED_UNICODE); ?>;
  </script>
 <script src="<?php echo BASE_URL; ?>/assets/js/ejerciciosPorGrupo.js"></script>
</body>
</html>