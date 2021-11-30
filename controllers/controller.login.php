<?php

require_once 'connection.php';

session_start();

if (isset($_POST['submit'])) {

    $user = $_POST['email'];
    $pass = $_POST['password'];
    $rol  = $_POST['rol'];

    $sql = mysqli_query(
        $conexion,
        "SELECT * FROM iconometer_users WHERE usr_email='$user' AND usr_password=MD5('$pass') AND rol_code='$rol' AND usr_status=1"
    );

    if ($res = mysqli_fetch_array($sql) != 0) {

        $_SESSION['email'] = $_POST['email'];

        header('Location: ../views/projects.php');
    } else {
        header('Location: ../views/login.php');

    }

    $sqlu = mysqli_query($conexion, "SELECT * FROM iconometer_users WHERE usr_email='$user' AND rol_code='$rol' AND usr_status=1");

    if ($resu = mysqli_fetch_array($sqlu) != 0) {

        $_SESSION['email'] = $_POST['email'];

        header('Location: ../views/projects.php');
    } else {
        header('Location: ../views/login.php');

    }
} else {
    echo 'mesnaje contrario';
}