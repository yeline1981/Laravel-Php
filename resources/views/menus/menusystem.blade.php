<div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">                      
            
            <li class="nav-title">Administración</li>
            
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
                      <i class="nav-icon "></i> Listar</a>
                  </li>                
                </ul>
            </li>
            

            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon fa fa-money fa-lg"></i> Caja</a>
                <ul class="nav-dropdown-items">
                   
                  
                  <li @click="menu=22" class="nav-item">
                    <a class="nav-link" href="#">
                      <i class="nav-icon fa fa-calculator fa-lg"></i> General</a>
                  </li>                 

                </ul>
            </li>
            
          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
            
