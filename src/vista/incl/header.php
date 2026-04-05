<div class="topbar-sesion">
        <div class="topbar-izquierda">
          <a
            href="mailto:tu-correo@ejemplo.com"
            class="text-decoration-none topbar-enlace topbar-enlace-icono topbar-contacto"
            aria-label="Contactar"
          >
            <i class="bi bi-envelope topbar-contacto-icono"></i>
            <span class="topbar-contacto-punto"></span>
          </a>
        </div>

        <div class="topbar-centro">
          <a
            href="<?php echo BASE_URL; ?>index.php?vista=clienteDashboard"
            class="topbar-logo-link"
            aria-label="Ir al inicio"
          >
            <img
              class="topbar-logo"
              src="<?php echo BASE_URL; ?>assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png"
              alt="Fitmemory"
            />
          </a>
        </div>
        <div class="topbar-derecha topbar-derecha-columna">
          <button
            class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 topbar-boton topbar-boton-ancho"
            type="button"
            onclick="window.location.href='<?php echo BASE_URL; ?>src/controlador/cierre_sesion.php'"
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
        </div>
      </div>