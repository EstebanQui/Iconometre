<?php
include_once '../controllers/connection.php';
echo '<script type="text/javascript" src="../js/varios.js"></script>';

if (isset($_POST['project'])) {
    //OTHER QUERY
    $sql = mysqli_query($conexion, "SELECT * FROM questions_projects  WHERE pro_code='".$_POST['project']."'");
    $row = mysqli_fetch_array($sql);

    //QUERY FOR SELECT
    $sqlque = mysqli_query($conexion, "SELECT * FROM questions_projects  WHERE pro_code='".$_POST['project']."'");
    echo '<label>Question</label>';
    echo '<select class="form-control" name="questions" id="questions" onclick="answer_ques()">';
    echo '<option disabled="" selected="">Select..</option>';
    while ($rowques = mysqli_fetch_array($sqlque)) {
        echo '<option value='.$rowques['que_code'].'>'.$rowques['que_description'].'</option>';
    }
    echo '</select>';
} elseif (isset($_POST['questions'])) {
    //THERE QUERY
    $ans2 = mysqli_query($conexion, "SELECT * FROM answers_questions  WHERE que_code='".$_POST['questions']."'");
    if (mysqli_num_rows($ans2) == 0) {
        echo '<label>Number Answers</label>';
        echo '<input type="text" class="form-control" name="number_answers" id="number_answers" onblur="addinputsanswers()">';
    } else {
        echo '<label>Aswers</label>';
        echo '<form action="../controllers/controller.projects.php" method="POST" name="form">';
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Answer</th>';
        echo '<th>Correct</th>';
        echo '<th>Edit</th>';
        echo '<th>Delete</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($rowanwers = mysqli_fetch_array($ans2)) {
            echo '<tr>';
            echo '<td><input type="text" name="answerdescri" value="'.$rowanwers['ans_description'].'" class="form-control"></td>';
            echo '<td><input type="text" name="anscorrect" value="'.$rowanwers['ans_correct'].'" class="form-control"></td>';
            echo '<td><input type="submit" class="btn btn-warning"  name="ans_codeu" id="ans_codeu" value="Edit"></td>';
            echo '<td><a href="../controllers/controller.projects.php?ans_coded='.$rowanwers['ans_code'].'"><img src="../images/eliminar.png" width="25" class="img-thumbnail"></a></td>';
            echo '<tr>';
        }
        echo '<tbody>';
        echo '</table>';
        echo '</form>';
        //echo '</select>';
    }
} else {

}

