<?php
require_once "connection.php";
$query = "SELECT * FROM iconometer_languages ORDER BY lan_description";
$lang  = mysqli_query($conexion, $query);

$query1 = "SELECT * FROM iconometer_languages ORDER BY lan_description";
$lang1  = mysqli_query($conexion, $query1);

$query2 = "SELECT * FROM iconometer_languages ORDER BY lan_description";
$lang2  = mysqli_query($conexion, $query2);

$query3 = "SELECT * FROM iconometer_languages ORDER BY lan_description";
$lang3  = mysqli_query($conexion, $query3);