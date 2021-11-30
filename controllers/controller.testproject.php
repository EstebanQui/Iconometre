<?php
require_once 'connection.php';
$codigoque = $_GET['que_code'];
$email = $_GET['email'];
$project = $_GET['project'];
//SQL INFORMATION USER
$user = mysqli_query($conexion, "SELECT * FROM iconometer_users WHERE usr_email='$email'");
$rowuser = mysqli_fetch_array($user);
$usercode = $rowuser['usr_code'];

echo $_GET['valor1'].'<br>';
echo $_GET['valor2'].'<br>';
echo $_GET['valor3'].'<br>';
echo $_GET['valor4'].'<br>';
echo $_GET['valor5'].'<br>';
echo $_GET['valor6'].'<br>';
echo $_GET['valor7'].'<br>';
echo $_GET['valor8'].'<br>';
echo $_GET['valor9'].'<br>';
echo $_GET['valor10'].'<br>';

$valores = array(
    $_GET['valor1'],
    $_GET['valor2'],
    $_GET['valor3'],
    $_GET['valor4'],
    $_GET['valor5'],
    $_GET['valor6'],
    $_GET['valor7'],
    $_GET['valor8'],
    $_GET['valor9'],
    $_GET['valor10'],
);
$answers = mysqli_query($conexion, "SELECT * FROM answers_questions WHERE que_code=$codigoque");
//saco el numero de elementos
$longitud = count($valores);
/*$sqlproject=mysqli_query($conexion,"SELECT * FROM projects WHERE pro_status=0");
    //$rowproject=mysqli_fetch_array($sqlproject);
    if($sqlproject==''){
        echo 'rien a faire';
    }else{*/
//Recorro todos los elementos
for ($i = 0; $i < $longitud; $i++) {//saco el valor de cada elemento
    
    while ($rowans = mysqli_fetch_array($answers)) {
        $listans = $rowans['ans_code'];
        $listval = $valores[$i++];
        $valor   = $rowans['ans_persons'] + 1;
        if ($listval == '') {
        } else {
            //$sql = mysqli_query($conexion,"INSERT INTO answer_questions VALUES(null,'".$_POST['optionalvalor']."','$codigoque','$listval','$valor')");

            $sql = mysqli_query($conexion,"UPDATE answers_questions SET  ans_persons='$valor' WHERE ans_code='$listans' AND que_code='$codigoque'");
            $sql = mysqli_query($conexion,"UPDATE tmp_answers SET tmp_valoration='$listval' WHERE ans_code='$listans' AND usr_code='$usercode'");
            if ($sql > 0) {
                if($_GET['fin']){
                    //echo 'fin test';
                    header('Location:../views/commentary.php?email='.$email.'&project='.$project.'');
                }else{
                    $quest = $codigoque + 1;
                    header('Location:../views/start_projects.php?quest='.$quest.'&email='.$email.'&project='.$project.'');
                }
                /*$quest = $codigoque + 1;
                header('Location:../views/start_projects.php?quest='.$quest.'&email='.$email.'&project='.$project.'');*/
            } else {
                echo 'Question Not Save';
            }
        }
    }
    
}
    


