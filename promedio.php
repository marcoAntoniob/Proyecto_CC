<?php

$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';

$conexion = mysqli_connect('database-1.cvwyjl87rro2.us-east-1.rds.amazonaws.com', 'admin', 'administrador');

$db = 'poy_cognitive';

$con = mysqli_select_db($conexion, $db) or die("no podemos conectarnos ");

$consulta = "SELECT count(*) from pulso  where email=\"$correo\";";
$consulta1 = "SELECT SUM(pulso) FROM pulso  where email=\"$correo\";";

$resultado = mysqli_query($conexion, $consulta);
$resultado1 = mysqli_query($conexion, $consulta1);

while ($traer = mysqli_fetch_array($resultado)) {
    $conteo = $traer[0];
}
while ($traer1 = mysqli_fetch_array($resultado1)) {
    $suma = $traer1[0];
}

if ($conteo!=0) {
    # code...
    $resultado = $suma / $conteo;
    echo number_format($resultado, 0);
}