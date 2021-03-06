<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /php-login');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email,tipo, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $tipo= $results['tipo'];
    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      if($tipo=="doctor"){
      header("Location: index.php");
      }else{
      header("Location: paciente.php");}
    } else {
    echo '<script language="javascript">alert("Usuario o contraseña no coinciden");</script>';
    header("Location: index.php");
    }
  }

?>


