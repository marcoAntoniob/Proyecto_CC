<?php
session_start();

require 'database.php';

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email,tipo, nombre, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $tipo = $results['tipo'];
    $user = null;

    if (count($results) > 0) {
        $user = $results;
        if ($tipo == "paciente") {
            header("Location: paciente.php");
        }
    }
}

$message = '';

$nombre_doc=$user['nombre'];
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO users (email, password, tipo,nombre, apellido) VALUES (:email, :password, :tipo,:name,:last_name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':tipo', $_POST['tipo']);
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':last_name', $_POST['last_name']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo '<script language="javascript">alert("Usuario creado");</script>';
    } else {
        $message = 'Sorry there must have been an issue creating your account';
    }
}
if (!empty($_POST['motivo']) ) {
    $sql = "INSERT INTO consultas ( calendario, fecha,doctor,email,motivo) VALUES ('Ortesistas', :fecha, '$nombre_doc',:paciente,:motivo)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fecha', $_POST['fecha']);
    $stmt->bindParam(':paciente', $_POST['paciente']);
    $stmt->bindParam(':motivo', $_POST['motivo']);

    if ($stmt->execute()) {
        echo '<script language="javascript">alert("Consulta creada");</script>';
    } else {
        $message = 'Sorry there must have been an issue creating your account';
    }
}

$conexion = mysqli_connect('database-1.cvwyjl87rro2.us-east-1.rds.amazonaws.com', 'admin', 'administrador');
$db = 'poy_cognitive';
$con = mysqli_select_db($conexion, $db) or die("no podemos conectarnos ");
$consulta = "SELECT * from users where tipo= 'paciente';";
$resultado = mysqli_query($conexion, $consulta);
$resultado1 = mysqli_query($conexion, $consulta);


?>

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

<body class=" layout-fixed ">


    <?php if (!empty($user)) : ?>
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <h3>Buen día, doctor <?= $user['nombre']; ?></h3>
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
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">
                    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Ortesistas</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="#" class="nav-link ">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Paciente
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php
                                    while ($traer = mysqli_fetch_array($resultado)) {
                                        echo "
                      <li class='nav-item'>
                    <a href='index3.php?paciente=" . $traer['id'] . "' class='nav-link'>
                      <i class='far fa-circle nav-icon'></i>
                      <p>" . $traer['nombre'] . "</p>
                    </a>
                  </li>
                      ";
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="crear_agendar.php" class="nav-link active">
                                    <i class="nav-icon fas fa-comment"></i>
                                    <p>
                                        Crear y agendar
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="row">
                    <!-- /.content-header -->
                    <section class="col-lg-6">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row ">
                                    <h4>Crear usuario de paciente</h4>
                                </div><!-- /.row -->

                            </div><!-- /.container-fluid -->
                        </div>

                        <div class="register-box">
                            <div class="card  card-primary">

                                <div class="card-body">

                                    <form action="crear_agendar.php" method="post">
                                        <div class="input-group mb-3">
                                            <select class="form-control" name="tipo">
                                                <option value="paciente">Paciente</option>
                                            </select>

                                        </div>
                                        <div class="input-group mb-3">
                                            <input name="name" type="name" class="form-control" placeholder="Nombre">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input name="last_name" type="last_name" class="form-control" placeholder="Apellido">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input name="email" type="email" class="form-control" placeholder="Email">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input name="password" type="password" class="form-control" placeholder="Password">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">

                                            </div>
                                            <!-- /.col -->
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-primary btn-block">Crear usuario</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>

                                </div>
                                <!-- /.form-box -->
                            </div><!-- /.card -->
                        </div>
                    </section>
                    <section class="col-lg-6">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row ">
                                    <h4>Agendar consulta médica</h4>
                                </div><!-- /.row -->

                            </div><!-- /.container-fluid -->
                        </div>
                        <div class="card card-info col-lg-10">

                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="crear_agendar.php" method="post" class="form-horizontal">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Paciente</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="paciente">
                                                <?php
                                                while ($traer = mysqli_fetch_array($resultado1)) {
                                                    echo "
                                          <option value='" . $traer['email'] . "'>" . $traer['nombre'] . "</option>
                                        ";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha</label>
                                        <div class="col-sm-7">
                                            <input type="date" name="fecha" class="form-control" id="inputEmail3">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-4 col-form-label">Motivo</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="motivo" class="form-control" id="inputPassword3">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">Crear consulta</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                    </section>
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
        <!----------------------------------------------------------------------------------------------------->
    <?php else : header('Location: index.php'); ?>
    <?php endif; ?>
</body>
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

</html>