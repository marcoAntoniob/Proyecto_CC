<?php
session_start();
require 'database.php';

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, nombre, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
        $user = $results;
    }
}

$conexion = mysqli_connect('database-1.cvwyjl87rro2.us-east-1.rds.amazonaws.com', 'admin', 'administrador');

$db = 'poy_cognitive';

$con = mysqli_select_db($conexion, $db) or die("no podemos conectarnos ");

$id_paciente = $user['id'];
$consulta = "SELECT * from users where tipo= 'paciente';";
$resultado1 = mysqli_query($conexion, $consulta);

$consulta = "SELECT * from users where id= $id_paciente;";
$resultado = mysqli_query($conexion, $consulta);

while ($traer = mysqli_fetch_array($resultado)) {
    $correo = $traer["email"];
    $nom_user = $traer["nombre"];
}

$consulta = "SELECT count(*) from angulo where email=\"$correo\";";
$resultado = mysqli_query($conexion, $consulta);

while ($traer = mysqli_fetch_array($resultado)) {
    $conteo = $traer[0];
}
$pmov =  ($conteo * 100) / 30000;

$consulta = "SELECT * from consultas where email=\"$correo\";";
$resultado = mysqli_query($conexion, $consulta);
?>
<?php if (!empty($user)) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ortesistas</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- IonIcons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
    </head>
    <!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

    <body class=" layout-fixed ">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <h3>Buen día, paciente <?= $user['nombre']; ?></h3>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fas fa-th-large"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item dropdown-footer">Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand ">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Ortesistas</span>
                </a>



                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box">

                                    <div class="info-box-content">
                                        <span class="info-box-text">Ritmo Cardiaco</span>
                                        <span class="info-box-number">
                                            <h2><b id="contenido"> </b><b>BPM</b></h2>

                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-4">

                                    <div class="info-box-content">
                                        <span class="info-box-text">Promedio BPM</span>
                                        <span class="info-box-number">
                                            <h2><b id="contenido2"> </b><b>BPM</b></h2>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-4">

                                    <div class="info-box-content">
                                        <span class="info-box-text">Ángulo de la pierna</span>
                                        <span class="info-box-number">
                                            <h2><b id="contenido1"> </b><b>°</b></h2>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->

                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Ritmo cardiaco </h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- /.d-flex -->
                                        <div class="position-relative mb-4">
                                            <canvas id="visitors-chart" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->

                                <!-- /.col -->
                                <div class="col-md-9 col-sm-6 col-6">
                                    <div class="info-box ">
                                        <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Meta mensual</span>
                                            <span class="info-box-number"><?php echo $conteo; ?></span>

                                            <div class="progress">
                                                <div class="progress-bar" style="width: <?php echo $pmov; ?>%; background-color: black;"></div>
                                            </div>

                                            <span class="progress-description">
                                                <?php echo number_format($pmov, 2); ?> de 30000
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col-md-6 -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header border-0">
                                        <div class="d-flex justify-content-between">
                                            <h3 class="card-title">Movimientos de rodilla</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- /.d-flex -->

                                        <div class="position-relative mb-4">
                                            <canvas id="sales-chart" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header border-0">
                                        <h3 class="card-title">Consultas médicas</h3>
                                    </div>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-striped table-valign-middle">
                                            <thead>
                                                <tr>
                                                    <th>Calendario</th>
                                                    <th>Fecha</th>
                                                    <th>Motivo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($traer = mysqli_fetch_array($resultado)) {
                                                    echo "
                        <tr>
                        <td>" . $traer['calendario'] . "</td>
                        <td>" . $traer['fecha'] . "</td>
                        <td>" . $traer['motivo'] . "</td>
                      </tr>
                       ";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE -->
        <script src="dist/js/adminlte.js"></script>

        <!-- OPTIONAL SCRIPTS -->
        <script src="plugins/chart.js/Chart.min.js"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="dist/js/pages/dashboard3.js"></script>
        <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
        <script>
            var correo;
            correo = "<?php echo $correo; ?>";

            function pulso() {
                var datos = $.ajax({
                    url: "pulso.php",
                    method: "POST",
                    datatype: "json",
                    data: {
                        correo: correo,
                    },
                    dataType: "text",
                    async: false
                }).responseText;

                var contenido = document.getElementById('contenido');
                contenido.innerHTML = datos;
            }

            function angulo() {
                var datos = $.ajax({
                    url: "angulo.php",
                    method: "POST",
                    datatype: "json",
                    data: {
                        correo: correo,
                    },
                    dataType: "text",
                    async: false

                }).responseText;

                var contenido = document.getElementById('contenido1');
                contenido.innerHTML = datos;

            }

            function promedio() {
                var datos = $.ajax({
                    url: "promedio.php",
                    method: "POST",
                    datatype: "json",
                    data: {
                        correo: correo,
                    },
                    dataType: "text",
                    async: false
                }).responseText;

                var contenido = document.getElementById('contenido2');
                contenido.innerHTML = datos;
            }

            setInterval(pulso, 10000);
            setInterval(angulo, 10000);
            setInterval(promedio, 10000);
        </script>

    </body>

    </html>

<?php else : header('Location: index.php'); ?>
<?php endif; ?>