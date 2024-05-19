<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$rol_id = $_SESSION['rol_id'];

if ($rol_id != 1) { // Asumiendo que el rol de 'admin' tiene el ID 1
    echo 'Acceso denegado. No tienes permiso para acceder a esta página.';
    exit();
}

// Contenido para administradores
echo '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escritorio</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('nav a, .side-menu a');
            const sections = document.querySelectorAll('main section');

            function showSection(id) {
                sections.forEach(section => {
                    section.classList.remove('active');
                });
                document.querySelector(id).classList.add('active');
            }

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    const id = this.getAttribute('href');
                    if (!id.startsWith('cerrar_sesion.php')) {  // Evitar la prevención del enlace de cierre de sesión
                        e.preventDefault();
                        showSection(id);
                    }
                });
            });
        });
    </script>
    <style>
        /* Agregar estilos adicionales para .active */
        section {
            display: none;
        }
        section.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="side-menu">
        <h2>Opciones</h2>
        <a href="#modificar">Modificar</a>
        <a href="#eliminar">Eliminar</a>
        <a href="#ajustar">Ajustar</a>
        <a href="#enviar-correo">Enviar Correo</a>
        <a href="cerrar_sesion.php"><span class="highlight">Salir</span></a>
    </div>
    <header>
        <h1>Bienvenido al sistema de Elite</h1>
    </header>
    <div class="container">
        <nav>
            <a href="#inicio">Inicio</a>
            <a href="#proveedores">Proveedores</a>
            <a href="#clientes">Clientes</a>
            <a href="#material-genetico">Material Genetico</a>
            <a href="#compras">Compras</a>
            <a href="#ventas">Ventas</a>
            <a href="#empleados">Empleados</a>
            <a href="#sementales">Sementales</a>
        </nav>
        <main>
            <section id="inicio" class="active">
                <h2>Inicio</h2>
                <p>Sistema para solamente administradores de Elite</p>
            </section>

            <section id="proveedores">
                <h2>Proveedores</h2>
                <p>Lista de <span class="highlight">Proveedores</span></p>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Raza</th>
                                <th>Clave</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dsn = 'mysql:host=localhost;dbname=bd_sistema;charset=utf8mb4';
                            $usuario = 'root';
                            $contraseña = '';

                            try {
                                $conexion = new PDO($dsn, $usuario, $contraseña);
                                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $stmt_proveedores = $conexion->query("SELECT * FROM proveedores");
                                $proveedores = $stmt_proveedores->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($proveedores as $proveedor) {
                                    echo '<tr>';
                                    echo '<td>' . $proveedor['id_proveedor'] . '</td>';
                                    echo '<td>' . $proveedor['nombre'] . '</td>';
                                    echo '<td>' . $proveedor['apellido'] . '</td>';
                                    echo '<td>' . $proveedor['telefono'] . '</td>';
                                    echo '<td>' . $proveedor['correo'] . '</td>';
                                    echo '<td>' . $proveedor['raza'] . '</td>';
                                    echo '<td>' . $proveedor['clave'] . '</td>';
                                    echo '</tr>';
                                }
                            } catch (PDOException $e) {
                                echo 'Error de conexión: ' . $e->getMessage();
                                exit();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="clientes">
                <h2>Clientes</h2>
                <p>Lista de <span class="highlight">Clientes</span></p>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Clave</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt_clientes = $conexion->query("SELECT * FROM clientes");
                                $clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($clientes as $cliente) {
                                    echo '<tr>';
                                    echo '<td>' . $cliente['id_cliente'] . '</td>';
                                    echo '<td>' . $cliente['nombre'] . '</td>';
                                    echo '<td>' . $cliente['apellido'] . '</td>';
                                    echo '<td>' . $cliente['telefono'] . '</td>';
                                    echo '<td>' . $cliente['correo'] . '</td>';
                                    echo '<td>' . $cliente['clave'] . '</td>';
                                    echo '</tr>';
                                }
                            } catch (PDOException $e) {
                                echo 'Error de conexión: ' . $e->getMessage();
                                exit();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="material-genetico">
                <h2>Material Genetico</h2>
                <p>Stock del <span class="highlight">Material Genetico</span></p>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Raza</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt_material_genetico = $conexion->query("SELECT id_material_genetico, raza, stock FROM material_genetico");
                                $material_genetico = $stmt_material_genetico->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($material_genetico as $item) {
                                    echo '<tr>';
                                    echo '<td>' . $item['id_material_genetico'] . '</td>';
                                    echo '<td>' . $item['raza'] . '</td>';
                                    echo '<td>' . $item['stock'] . '</td>';
                                    echo '</tr>';
                                }
                            } catch (PDOException $e) {
                                echo 'Error de conexión: ' . $e->getMessage();
                                exit();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="compras">
                <h2>Compras</h2>
                <p>Lista de informacion de todas las <span class="highlight">Compras</span> realizadas a los proveedores</p>
            </section>

            <section id="ventas">
                <h2>Ventas</h2>
                <p>Lista de informacion de todas las <span class="highlight">Ventas</span> realizadas a los clientes</p>
            </section>

            <section id="empleados">
                <h2>Empleados</h2>
                <p>Lista de <span class="highlight">Empleados</span>.</p>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt_empleados = $conexion->query("SELECT * FROM empleados");
                                $empleados = $stmt_empleados->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($empleados as $empleado) {
                                    echo '<tr>';
                                    echo '<td>' . $empleado['id_empleado'] . '</td>';
                                    echo '<td>' . $empleado['nombre'] . '</td>';
                                    echo '<td>' . $empleado['apellido'] . '</td>';
                                    echo '</tr>';
                                }
                            } catch (PDOException $e) {
                                echo 'Error de conexión: ' . $e->getMessage();
                                exit();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="sementales">
                <h2>Sementales</h2>
                <p>Lista de los <span class="highlight">Sementales</span></p>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Raza</th>
                            <th>Edad</th>
                            <th>Material Genetico ID</th>
                            <th>Corral ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt_sementales = $conexion->query("SELECT * FROM sementales");
                            $sementales = $stmt_sementales->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($sementales as $semental) {
                                echo '<tr>';
                                echo '<td>' . $semental['id_semental'] . '</td>';
                                echo '<td>' . $semental['raza'] . '</td>';
                                echo '<td>' . $semental['edad'] . '</td>';
                                echo '<td>' . $semental['material_genetico_id'] . '</td>';
                                echo '<td>' . $semental['corral_id'] . '</td>';
                                echo '</tr>';
                            }
                        } catch (PDOException $e) {
                            echo 'Error de conexión: ' . $e->getMessage();
                            exit();
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <section id="modificar">
                <h2>Modificar</h2>
                <p>Aquí puedes modificar los datos necesarios.</p>
            </section>

            <section id="eliminar">
                <h2>Eliminar</h2>
                <p>Aquí puedes eliminar los datos necesarios.</p>
            </section>

            <section id="ajustar">
                <h2>Ajustar</h2>
                <p>Aquí puedes ajustar la configuración.</p>
            </section>

            <section id="enviar-correo">
                <h2>Enviar Correo</h2>
                <p>Enviar correo para cualquier aclaracion o duda</p>
                <form action="#" method="post">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" rows="4" required></textarea>
                    <button type="submit">Enviar</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>


