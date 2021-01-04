
<div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">

            <li class="nav-title">Imprenta</li>

            <li @click="menu=13" class="nav-item">
              <a class="nav-link" href="#">
              <i class="nav-icon icon-plus"></i> Nueva Solicitud</a>
            </li>

            <li @click="menu=12" class="nav-item">
              <a class="nav-link" href="#">
              <i class="nav-icon fa fa-question"></i> Listar Solicitudes</a>
            </li>

            <!--
            <li @click="menu=15" class="nav-item">
              <a class="nav-link" href="#">
              <i class="nav-icon fa fa-paint-brush"></i> Mockup</a>
            </li>
            -->


            <li class="nav-title">Producción</li>

            <li @click="menu=10" class="nav-item">
              <a class="nav-link" href="#">
              <i class="nav-icon fa fa-table"></i> Listar Trabajos</a>
            </li>

            <li class="nav-title">Gestión</li>

              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon fa fa-users"></i> Clientes</a>

                  <ul class="nav-dropdown-items">

                      <li @click="menu=9" class="nav-item">
                          <a class="nav-link" href="#">
                          <i class="nav-icon"></i> Nuevo</a>
                      </li>

                      <li @click="menu=11" class="nav-item">
                        <a class="nav-link" href="#">
                          <i class="nav-icon "></i> Ver Todos</a>
                      </li>
                  </ul>
              </li>

              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon fa fa-money fa-lg"></i> Caja</a>
                  <ul class="nav-dropdown-items">

                    <li @click="menu=5" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> Facturación</a>
                    </li>

                    <li @click="menu=4" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> General</a>
                    </li>

                    <li @click="menu=7" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon"></i> Venta del día</a>
                    </li>

                    <li @click="menu=6" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> Deudores</a>
                    </li>

                  </ul>
              </li>

            <li class="nav-title">Administración</li>
<!--
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon fa fa-cogs fa-lg"></i> Ajustes</a>
                  <ul class="nav-dropdown-items">
                    <li @click="menu=4" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> Atributos</a>
                    </li>

                  </ul>
              </li>
-->
              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon icon-people"></i> Usuarios</a>
                  <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> Nuevo</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon"></i> Ver Todos</a>
                    </li>
                  </ul>
              </li>

              <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                  <i class="nav-icon icon-chart"></i> Reportes</a>
                  <ul class="nav-dropdown-items">
                    <li @click="menu=24" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> Tipos Trabajos</a>
                    </li>
                    <li @click="menu=25" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> Tendencias</a>
                    </li>
                    <!--
                    <li @click="menu=26" class="nav-item">
                      <a class="nav-link" href="#">
                        <i class="nav-icon "></i> Clientes</a>
                    </li>
                    -->
                  </ul>
              </li>

          </ul>

        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

