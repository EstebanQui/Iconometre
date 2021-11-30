<?php
include_once 'connection.php';
$email = $_POST['email'];
$project = $_POST['project'];
$commentary = $_POST['commentary'];

$sql_user=mysqli_query($conexion,"SELECT * FROM iconometer_users WHERE usr_email='$email'");
$rowusers=mysqli_fetch_array($sql_user);

$sql=mysqli_query($conexion,"INSERT INTO commentary VALUES (null,'".$rowusers['usr_code']."','$project','$commentary')");
if($sql>0){
    $ins=mysqli_query($conexion,"INSERT INTO projects_users VALUES(null,'$project','".$rowusers['usr_code']."','COMPLETED')");
    if($ins>0){
        header('Location:../views/projects.php');
    }else{
        echo 'error';
    }    
}else{
    
}
