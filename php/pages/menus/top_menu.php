
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item <?php echo $current_page == 'index' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=index">Inicio</a>
            </li>
            <li class="nav-item <?php echo $current_page == 'releases' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=releases">Próximos artículos</a>
            </li>
            <li class="nav-item <?php echo $current_page == 'offers' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=offers">Ofertas</a>
            </li>
            <li class="nav-item dropdown <?php echo $current_page == 'shipping/shippingOptions' || $current_page == 'shipping/terms' || 
                                                    $current_page == 'shipping/returnPolitics'  || $current_page == 'shipping/warranty'  ? 'active' : ''; ?>">
                <a class="nav-link dropdown-toggle" href="#" id="shipping" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Envíos
                </a>
                <div class="dropdown-menu" aria-labelledby="shipping">
                    <a class="dropdown-item" href="?page=shipping/shippingOptions">Formas de envío</a>
                    <a class="dropdown-item" href="?page=shipping/terms">Condiciones</a>
                    <a class="dropdown-item" href="?page=shipping/returnPolitics">Políticas de devolución</a>
                    <a class="dropdown-item" href="?page=shipping/warranty">Garantía</a>
                </div>
            </li>
            <li class="nav-item <?php echo $current_page == 'about' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=about">Quienes somos</a>
            </li>
            <li class="nav-item <?php echo $current_page == 'contact' ? 'active' : ''; ?>">
                <a class="nav-link" href="?page=contact">Contacto</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar artículo" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                    </svg>
                    Mi carrito <span style="color:red;">(2)</span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Camara - 134,00€</a>
                    <a class="dropdown-item" href="#">Pen Drive - 10,00€</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><b>Total (2): 166,23€</b></a>
                    <div class="dropdown-divider"></div>
                    <center><a class="btn btn-secondary" href="?page=shoppingCart" role="button" style="width: 90%;">Ver carrito</a></center>
                </div>
            </li>

            <?php
            //unset($_SESSION['current_session']);
            $session = null;
            if(isset($_SESSION["current_session"])) {
                $session = $_SESSION["current_session"];
            }
            //var_dump($session);
            if(!$session) {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="?page=login/login">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                    Ingresar
                </a>
            </li>
            <?php
            } else {
            ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z"/>
                            <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
                        </svg>
                        <?php echo $session["email"]; ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?page=private/my-account">Mi cuenta</a>
                        <a class="dropdown-item" href="?page=private/my-orders">Mis pedidos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="php/security/logout.php"><b>Cerrar sesión</a>
                    </div>
                </li>
            </ul>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>