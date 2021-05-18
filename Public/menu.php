<style>
    .navbar-center { 
        float: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #f1f1f1
    }
    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<header>
    <nav class="navbar navbar-inverse" style="background-color: #90CAF9!important;">        
        <div class="nav navbar-nav navbar-center">
            <strong id="resp">
                <?php if(App\Session::get('cantidad') > 0): ?>
                    <a href="index.php?c=historial&a=index&id=<?php echo App\Session::get('log_id'); ?>" style='color:black; text-decoration: none;'>
                        <img src='Public/img/a.svg' style='width: 40px;' />
                        &nbsp;<?php echo "(".App\Session::get('cantidad').")"; ?>
                    </a>
                <?php else: ?>
                    <img src='Public/img/a.svg' style='width: 40px;' />&nbsp;( 0 )
                <?php endif; ?>
            </strong>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <i class="fas fa-bars"></i>
                    </a>
                    <div class="dropdown-content">
                        <?php if(App\Session::get('log_in') != null): ?>
                            <?php if(App\Session::get('log_in') == "administrador"): ?>
                                <a href="index.php?c=roles&a=index">
                                    <i class="fas fa-tasks"></i>&nbsp;Roles
                                </a>
                                <br />
                                <a href="index.php?c=productos&a=index">
                                    <i class="fas fa-store-alt"></i>&nbsp;Productos
                                </a>
                                <br />
                                <a href="index.php?c=usuarios&a=index">
                                    <i class="fas fa-users-cog"></i>&nbsp;Usuarios
                                </a>
                                <br />
                                <a href="index.php?c=pagos&a=link&id=<?php echo App\Session::get('log_id'); ?>">
                                    <i class="fas fa-link"></i>&nbsp;Link de pago
                                </a>
                                <br />
                            <?php endif; ?>
                            <a class="dropdown-item" href="index.php?c=usuarios&a=view&id=<?php echo App\Session::get('log_id'); ?>">
                                <i class="fas fa-user-tag"></i>&nbsp;Ver cuenta
                            </a>
                            <br />
                            <a class="dropdown-item" href="index.php?c=usuarios&a=logout">
                                <i class="fas fa-lock"></i>&nbsp;Cerrar sesion
                            </a>
                            <br />
                        <?php else: ?>
                            <a class="dropdown-item" href="index.php?c=usuarios&a=login">
                                <i class="fas fa-lock-open"></i>&nbsp;Iniciar sesion
                            </a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
            <a class="navbar-brand" href="index.php?c=main&a=index">
                <img src="Public/img/logo-mywebsite-urian-viera.svg" width="120" />
            </a>
        </div>        
    </nav>
</header>