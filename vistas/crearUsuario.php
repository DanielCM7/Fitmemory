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
    <link href="/workspacevc/Fitmemory/assets/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/workspacevc/Fitmemory/assets/dist/css/sign-in.css" rel="stylesheet" />
    
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
      <form>
     
       <div class="row mb-3 align-items-center">
      <label class="col-sm-4 col-form-label text-start">USUARIO:</label>
      <div class="col-sm-8">
          <input type="text"
          class="form-control"
            id="idUsuario"
            placeholder="usuario">
          </div>
</div>

        <div class="row mb-3 align-items-center">
      <label class="col-sm-4 col-form-label text-start">NOMBRE:</label>
      <div class="col-sm-8">
          <input type="text"
            class="form-control"
            id="idNombre"
            placeholder="nombre">
          </div>  
</div>
        <div class="row mb-3 align-items-center">
      <label class="col-sm-4 col-form-label text-start">APELLIDOS:</label>
      <div class="col-sm-8">
          <input type="text"
            class="form-control"
            id="idApellidos"
            placeholder="apellidos">
        </div>
</div>
         <div class="row mb-3 align-items-center">
      <label class="col-sm-4 col-form-label text-start">EDAD:</label>
      <div class="col-sm-8">
          <input type="number"
            class="form-control"
            id="idEdad"
            placeholder="edad">
          </div>  
</div>
         <div class="row mb-3 align-items-center">
      <label class="col-sm-4 col-form-label text-start">PERFIL:</label>
      <div class="col-sm-8">
          <input type="text"
            class="form-control"
            id="idPerfil"
            placeholder="perfil">
          </div>
</div>
        <div class="row mb-3 align-items-center">
        <label class="col-sm-4 col-form-label text-start">CONTRASEÑA:</label>  
        <div class="col-sm-8">
          <input
            type="password"
            class="form-control"
            id="IdPassword"
            placeholder="contraseña"
          />
           </div>
        </div>
        <div class="position-fixed bottom-0 end-0 mb-4 me-4 d-flex gap-2">
        <button class="btn btn-primary btn-lg" type="submit">
          Continuar
        </button>
</div>