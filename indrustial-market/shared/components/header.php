<header>
    <div class="header-container">
        <div onclick="changeView('home')">
            <h1 class="logo">Hardware Store</h1>
            <h3 class="sublogo">Nuts and Bolts</h3>
        </div>
        <div class="right-menu">
            <button type="button" class="btn btn-ligh px-4 py-2 login">Registrar Cliente</button>
            <button type="button" class="btn btn-dark px-4 py-2" onclick="changeView('adminProductos', '', 'php')">Administración</button>
            <div class="cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge">3</span> 
            </div>
        </div>
    </div>
</header>
<nav class="main-nav">
    <ul>
    <?php if (!isset($show_new)){ ?>
        <li><a href="#catalog" onclick="changeView('home', 'catalog')">Productos más destacados</a></li>
        <li><a href="#" onclick="changeView('nuevaCotizacion','', 'php')">Cotización en línea</a></li>
        <li><a href="#" onclick="changeView('productos')">Catálogo</a></li>
        <li><a href="#map" onclick="changeView('home', 'map')">Contacto</a></li>
        <?php }else{ ?>
        <li><a href="#" onclick="changeView('adminProductos', '', 'php')">Productos</a></li>
        <li><a href="#" onclick="changeView('adminUsuarios', '', 'php' )">Clientes</a></li>
        <?php } ?>
    </ul>
</nav>