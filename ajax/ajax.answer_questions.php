<?php
include_once '../controllers/connection.php';
error_reporting(0);

if (($_POST['valor1']) or ($_POST['valor2']) or ($_POST['valor3']) or ($_POST['valor4']) or ($_POST['valor5']) or
    ($_POST['valor6']) or ($_POST['valor7']) or ($_POST['valor8']) or ($_POST['valor9']) or ($_POST['valor10'])) {
    $res = $_POST['valor1'] + $_POST['valor2'] + $_POST['valor3'] + $_POST['valor4'] + $_POST['valor5'] + $_POST['valor6'] + $_POST['valor7'] + $_POST['valor8'] + $_POST['valor9'] + $_POST['valor10'];
    echo $total = ' Total <input type="text" class="" name="total" value="'.$res.'" size="2" readonly>';
    if ($res == 100) {
        echo '<input type="hidden" value="'.$_POST['question'].'">';
        echo '<input type="hidden" value="'.$_POST['email'].'">';
        echo '<input type="hidden" value="'.$_POST['project'].'">';
        $sql_quest=mysqli_query($conexion, "SELECT MAX(que_code) AS id FROM questions_projects WHERE pro_code ='".$_POST['project']."'");
        $rowques=mysqli_fetch_array($sql_quest);
            /*echo $_POST['question'];
            echo $rowques['id'];*/
            if($rowques['id']<>$_POST['question']){
                echo '<a class="btn btn-success ntx_question" href="../controllers/controller.testproject.php?que_code='.$_POST['question'].'&email='.$_POST['email'].'&project='.$_POST['project'].'
                &valor1='.$_POST['valor1'].'&valor2='.$_POST['valor2'].'&valor3='.$_POST['valor3'].'&valor4='.$_POST['valor4'].'
                &valor5='.$_POST['valor5'].'&valor6='.$_POST['valor6'].'&valor7='.$_POST['valor7'].'&valor8='.$_POST['valor8'].'
                &valor9='.$_POST['valor9'].'&valor10='.$_POST['valor10'].'&optional='.$_POST['optionalvalor'].'">Next Question</a><br><br>';
            }else{
                $fin='<a class="btn btn-success ntx_question" href="../controllers/controller.testproject.php?que_code='.$_POST['question'].'&email='.$_POST['email'].'&project='.$_POST['project'].'&fin='.fin.'
                &valor1='.$_POST['valor1'].'&valor2='.$_POST['valor2'].'&valor3='.$_POST['valor3'].'&valor4='.$_POST['valor4'].'
                &valor5='.$_POST['valor5'].'&valor6='.$_POST['valor6'].'&valor7='.$_POST['valor7'].'&valor8='.$_POST['valor8'].'
                &valor9='.$_POST['valor9'].'&valor10='.$_POST['valor10'].'&optional='.$_POST['optionalvalor'].'">Fin Test</a><br><br>';
                echo $fin;

            }

    } elseif ($res < 100) {
        echo $_POST['optionalvalor'];
        echo '<div class="alert alert-warning" role="alert">must meet 100% to continue!</div>';
    } elseif ($res > 100) {
        echo '<div class="alert alert-warning" role="alert">cannot exceed 100%!</div>';
    } elseif ($_POST['optionalvalor'] == 100) {
        echo 'llega 100 optional';
    }
} else {
    $res = '';
}

