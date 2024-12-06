<nav>
    <ul>
        <!-- Enlace a la página de inicio -->
        <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>

        <!-- Sección de usuarios, visible solo si el rol del usuario es 1 -->
        <?php if ($_SESSION['rol'] == 1) { ?>
            <li class="principal">
                <a href="#"><i class="fas fa-user"></i> Usuarios</a>
                <ul>
                    <li><a href="lista_usuarios.php"><i class="fas fa-users"></i> Lista de usuarios</a></li>
                </ul>
            </li>
        <?php } ?>

        <!-- Sección de clientes -->
        <li class="principal">
            <a href="#"><i class="fas fa-users"></i> Clientes</a>
            <ul>
                <li><a href="lista_cliente.php"><i class="fas fa-users"></i> Lista de clientes</a></li>
            </ul>
        </li>

        <!-- Sección de proveedores, visible solo si el rol del usuario es 1 o 2 -->
        <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
            <li class="principal">
                <a href="#"><i class="far fa-building"></i> Proveedores</a>
                <ul>
                    <li><a href="lista_proveedor.php"><i class="far fa-building"></i> Lista de proveedores</a></li>
                </ul>
            </li>
        <?php } ?>

        <!-- Sección de productos -->
        <li class="principal">
            <a href="#"><i class="fas fa-cubes"></i> Productos</a>
            <ul>
                <li><a href="lista_producto.php"><i class="fas fa-cubes"></i> Lista de productos</a></li>
            </ul>
        </li>

        <!-- Sección de otros, visible solo si el rol del usuario es 1 o 2 -->
        <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
            <li class="principal">
                <a href="#"><i class="fas fa-plus"></i> Otros</a>
                <ul>
                    <!-- Otros enlaces si es necesario -->
                </ul>
            </li>
        <?php } ?>

        <!-- Sección de configuración -->
        <li class="principal">
            <a href="#"><i class="fas fa-plus"></i> Otros</a>
            <ul>
                <li><a href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a></li>
            </ul>
        </li>
    </ul>
</nav>
