<?php

// FUNCIONES QUE CONTROLAN CABECERAS DINÁMICAS O ELEMENTOS REPETITIVOS DEL HTML

// Función que genera la cabecera de inicio (header) según si se está o no logueado
function cabeceraWeb()
{
    $baseUrl = BASE_URL;

    $mail = "";
    $menuUsuario = "";

    if (isset($_SESSION['usuario'])) {
        $mail = <<<HTML
    <a
        href="mailto:tu-correo@ejemplo.com"
        class="text-decoration-none topbar-enlace topbar-enlace-icono topbar-contacto"
        aria-label="Contactar"
        >
        <i class="bi bi-envelope topbar-contacto-icono"></i>
        <span class="topbar-contacto-punto"></span>
    </a>
    HTML;

        $menuUsuario = <<<HTML
    <button
        class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 topbar-boton topbar-boton-ancho"
        type="button"
        onclick="window.location.href='{$baseUrl}src/controlador/cierre_sesion.php'"
        >
        <span>Cerrar sesion</span>
        <i class="bi bi-door-open"></i>
        </button>

        <button
        class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 topbar-boton topbar-boton-ancho"
        type="button"
        >
        <span>Editar perfil</span>
        <i class="bi bi-person-circle"></i>
    </button>
    HTML;
    }

    echo <<<HTML
      <div class="topbar-sesion">
        <div class="topbar-izquierda">
            {$mail}
        </div>
        <div class="topbar-centro">
            <img
              class="topbar-logo"
              src="{$baseUrl}assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png"
              alt="Fitmemory"
            />
          </a>
        </div>
        <div class="topbar-derecha topbar-derecha-columna">
            {$menuUsuario}
        </div>
      </div>
    HTML;
}
