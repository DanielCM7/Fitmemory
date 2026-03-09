<!doctype html>
<html lang="es" data-bs-theme="dark">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta
      name="author"
      content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
    />
    <meta name="generator" content="Astro v5.13.2" />
    <title>Fitmemory</title>
    
    <link
      rel="canonical"
      href="index.php"
    />
    
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/dist/css/sign-in.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: #0000001a;
        border: solid rgba(0, 0, 0, 0.15);
        border-width: 1px 0;
        box-shadow:
          inset 0 0.5em 1.5em #0000001a,
          inset 0 0.125em 0.5em #00000026;
      }
      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }
      .bi {
        vertical-align: -0.125em;
        fill: currentColor;
      }
      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }
      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
  
    </style>
    
  </head>

   <body class="d-flex align-items-center py-4 bg-body-tertiary">

    <main class="form-signin w-100 m-auto">
       <?php include "incl/header.php";?>
<div class="position-absolute top-0 start-0 m-3">
  <a href="mailto:tu-correo@ejemplo.com" class="text-decoration-none d-flex align-items-center gap-2">
    <i class="bi bi-envelope-at-fill fs-4"></i>
    <span class="d-none d-m-inline">Contactar</spam>
</a>
</div>
<div class="position-absolute top-0 end-0 m-3">
  <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1 btn-top-header">
    <i class="bi bi-arrow-bar-right"></i>
    <span class="d-none d-sm-inline">Cerrar Sesión</spam>
</button>
<button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1 btn-top-header">
    <i class="bi bi-person-gear"></i>
    <span class="d-none d-sm-inline">Editar Perfil</spam>
</button>
</div>
    <div class="container text-center mt-5">

        <div class="d-flex justify-content-center gap-3 mb-3">
         
            <button class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2" type="submit"><i class="bi bi-person-add"></i>Nueva Sesión</button>
            <button class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2" type="submit"><i class="bi bi-clipboard-data"></i>Mis Sesiones</button>
          </div>
    
      <div class="text-center">
          
            <button class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2" type="submit"><i class="bi bi-graph-up"></i>Mi Progreso</button>
      
        </div>
       
     
</body>
</html>