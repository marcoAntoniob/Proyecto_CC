<?php

$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
$conexion = mysqli_connect('database-1.cvwyjl87rro2.us-east-1.rds.amazonaws.com', 'admin', 'administrador');

$db = 'poy_cognitive';

$con = mysqli_select_db($conexion, $db) or die("no podemos conectarnos ");

$consulta = "select * from angulo  where email=\"$correo\" ORDER BY id DESC LIMIT 1";

$resultado = mysqli_query($conexion, $consulta);


while ($traer = mysqli_fetch_array($resultado)) {
  echo $traer[3];
}
