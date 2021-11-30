<?php
require_once 'connection.php';

$name          = $_POST['name'];
$surname       = $_POST['surname'];
$email         = $_POST['email'];
$language      = $_POST['language'];
$languagehigh  = $_POST['languagehigh'];
$languageint   = $_POST['languageint'];
$languagebasic = $_POST['languagebasic'];
$comentary     = $_POST['comentary'];

echo $languajemult = json_encode($languagehigh, true);
echo $languajemult1 = json_encode($languageint, true);
echo $languajemult2 = json_encode($languagebasic, true);
$sql = mysqli_query($conexion,"INSERT INTO iconometer_users VALUES(null,'$name','$surname','','$email','$language','$languajemult','$languajemult1','$languajemult2','$comentary','2','1')");

if ($sql > 0) {
    header('Location: ../views/login.php');
} else {
    echo 'Not Save';
}