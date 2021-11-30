<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Case</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
<?php
include_once '../controllers/connection.php';
session_start();
if(isset($_SESSION['email'])){
    if(isset($conexion)){
        $questionget = $_GET['quest'];
        $email       = $_GET['email'];
        $projectg    = $_GET['project'];
        /****************QUERY SAVE QUESTIONS TMP_ANWERS FOR USERS*********************
         *****************************************************************************/
        $saveq = mysqli_query($conexion, "SELECT a.ans_code, a.ans_description, a.ans_valoration, a.ans_persons, q.que_code,
        q.que_description, p.pro_code, p.pro_subject, p.pro_status FROM answers_questions a, questions_projects q, projects p
        WHERE  a.que_code=q.que_code  AND q.pro_code=p.pro_code");
        //QUERY USERS
        $user    = mysqli_query($conexion, "SELECT usr_code FROM iconometer_users WHERE usr_email='$email'");
        $rowuser = mysqli_fetch_array($user);
        //QUERY TMP_ANWERS
        $usertmp=mysqli_query($conexion,"SELECT t.tmp_code,t.tmp_valoration,t.usr_code, a.ans_code,a.ans_description, a.ans_valoration,q.que_code, q.que_description
        FROM tmp_answers t, answers_questions a, questions_projects q
        WHERE t.ans_code=a.ans_code AND a.que_code=q.que_code AND t.usr_code='".$rowuser['usr_code']."' AND q.que_code <> '".$questionget."'");

        //QUERY ANSWERS
        $select=mysqli_query($conexion,"SELECT * FROM tmp_answers
        RIGHT JOIN answers_questions ON tmp_answers.ans_code=answers_questions.ans_code
        WHERE tmp_answers.usr_code ='' OR tmp_answers.usr_code is null");
        //INSERT TMP_ANWERS ALLS QUESTIONS

        if(mysqli_num_rows($usertmp)>0){
            foreach ($select as $selectn){
                $query   = mysqli_query($conexion,"INSERT INTO tmp_answers VALUES (null,'".$selectn['ans_code']."','0','".$rowuser['usr_code']."')");
            }
        }else{
            foreach ($saveq as $value) {
                $query   = mysqli_query($conexion, "INSERT INTO tmp_answers VALUES (null,'".$value['ans_code']."','0','".$rowuser['usr_code']."')");
            }
        }
        /**************** END QUERY SAVE QUESTIONS TMP_ANWERS FOR USERS****************
         *****************************************************************************/

        /****************VALIDATION QUESTION AND PROJECT FOR COMMENTARY****************
         *****************************************************************************/
        //SQL INFORMATION USER
        $usuari = mysqli_query($conexion,"SELECT u.usr_code, u.usr_name, u.usr_surname, u.usr_email, t.tmp_code, t.tmp_valoration,
        t.usr_code AS code_user FROM iconometer_users u, tmp_answers t WHERE u.usr_code = t.usr_code AND u.usr_email ='".$_SESSION['email']."'");
        $rowusuari = mysqli_fetch_array($usuari);
        //SQL INFORMATION PROJECT FOR QUESTION
        $sqlpro    = mysqli_query($conexion, "SELECT q.que_code, q.que_description, p.pro_code, p.pro_name, p.pro_subject, p.pro_status
        FROM questions_projects  q, projects p WHERE  q.pro_code=p.pro_code AND q.que_code='$questionget' AND  p.pro_status=1");
        $rowsqlpro = mysqli_fetch_array($sqlpro);
        //SQL TOTAL QUESTIONS
        $project3    = mysqli_query($conexion,"SELECT count(*) as total_questions FROM questions_projects WHERE pro_code='".$rowsqlpro['pro_code']."'");
        $rowproject3 = mysqli_fetch_array($project3);
        //
        $project    = mysqli_query($conexion,"SELECT * FROM projects WHERE pro_status=1 AND pro_code='".$rowsqlpro['pro_code']."'");
        $rowproject = mysqli_fetch_array($project);
        //
        $project2    = mysqli_query($conexion,"SELECT count(*)  as total_ans FROM answers_questions WHERE que_code='$questionget'");
        $rowproject2 = mysqli_fetch_array($project2);
        //
        if(($rowproject3['total_questions']<>$questionget) && $projectg <> $rowsqlpro['pro_code']){
            echo '<center>';
            echo '<form action="../controllers/controller.projects.php" method="POST">';
            echo "<label class='end' for='comentary'>Thanks for completing this test, leave us a comment.</label>";
            echo "<input type='hidden' name='user' value='".$rowusuari['usr_code']."'>";
            echo "<input type='hidden' name='project' value='1'>";
            echo "<textarea name='comentary' class='form-control'></textarea><br>";
            echo "<input type='submit' name='submit_comentary' id='submit_comentary' class='btn btn-success'>";
            echo '</form>';
            echo '</center>';
        }else{
            echo '<h2>Project:'.$rowproject['pro_name'].'</h2>';
            echo '<div class="card">';
            echo '<div class="card-header title">
                    <p><h3>Test Theme: '.$rowproject['pro_subject'].' </h3></p>
                  </div>';
            echo '<div class="card-body">';
            echo '<div class="content">';
            //THE QUESTION ARRIVES BY GET FROM THE RECORDS FORM
            $questget = $_GET['quest'];
            $sqlq = mysqli_query($conexion,"SELECT * FROM questions_projects AS questions INNER JOIN projects AS pro ON questions.pro_code=pro.pro_code WHERE que_code=$questget AND pro.pro_status=1");
            if ($rowq = mysqli_fetch_array($sqlq)){
                echo '<strong>'.$rowq['que_description'].'</strong><br>';
                $que = $rowq['que_code'];
                echo '<div class="row">';
                echo '<div class="col-sm-6">
                      <img class=" icon img-fluid img-thumbnail" src="../images/'.$rowq['que_image'].'">
                      </div>';

            }else{
                echo 'nathing';
            }
            echo '<div class="col-sm-6">';
            //TOTAL QUESTIONS
            $totanswer = mysqli_query($conexion,"SELECT count(*) AS total_answer FROM tmp_answers t,  answers_questions a,
            questions_projects q,   iconometer_users u WHERE   t.ans_code = a.ans_code AND a.que_code = q.que_code AND t.usr_code = u.usr_code
            AND q.que_code = '".$rowsqlpro['que_code']."' AND u.usr_code='".$rowusuari['usr_code']."'");
            $rowtotal  = mysqli_fetch_array($totanswer);
            //LIST OF ANSWERS FOR QUESTIONS
            for ($i = 1; $i <= $rowtotal['total_answer']; $i++) {
                $sqlanswer = mysqli_query($conexion,"SELECT t.tmp_code, t.tmp_valoration as valoration, a.ans_code, a.ans_description, q.que_code,
                                q.que_description,u.usr_code, u.usr_email FROM tmp_answers t, answers_questions a, questions_projects q, iconometer_users u
                                WHERE t.ans_code=a.ans_code and a.que_code=q.que_code AND t.usr_code=u.usr_code
                                AND q.que_code='".$rowsqlpro['que_code']."' AND u.usr_code='".$rowusuari['usr_code']."'");
                while ($rowanswer = mysqli_fetch_array($sqlanswer)) {
                    echo '<tr>';
                    if ($rowanswer['ans_description'] == '') {
                        echo '<div id="element" class="col-lg-12" style="display: none;">';
                        echo '<li>';
                        echo '<td width="15" style="text-align:left"><input type="text"  name="valor" id="valor'.$i++.'" size="2"  value="'.$rowanswer['valoration'].'" onchange="answer_questions()"></td>';
                        echo '<td width="15" style="text-align:left">%</td>';
                        
                        echo '</li>';
                        echo '</div>';
                    } else {
                        echo '<li>';
                        echo '<td width="15" style="text-align:left"><input type="text"  name="valor" id="valor'.$i++.'" size="2"  value="'.$rowanswer['valoration'].'" onchange="answer_questions()"></td>';
                        echo '<td width="15" style="text-align:left">%</td>';
                        echo '<td><input  type="text"  maxlength="3" size=""  value="'.$rowanswer['ans_description'].'" readonly></td>';
                        echo '</li>';
                    }
                    echo '</tr>';
                    echo '<br>';
                }
            }
            //QUERY FOR ADD BUTON
            $projectbutton    = mysqli_query($conexion,"SELECT count(*) as total_questions FROM questions_projects WHERE pro_code='".$rowsqlpro['pro_code']."'");
            $rowprojectbutton = mysqli_fetch_array($projectbutton);

                if($rowprojectbutton['total_questions']>$questionget){
                    echo '<p><a class="btn btn-primary" href="#" id="show"><i class="fa fa-eye"></i> Add Answer</a></p>';
                }else{
                    echo '<p><a class="btn btn-primary" href="#" id="show"><i class="fa fa-eye"></i> Add Answer</a></p>';
                }

            //DIV FOR AJAX
            echo '<div id="resultadoval"></div>';
            //PAGINATION QUESTIONS
            $sqltque = mysqli_query($conexion,"SELECT count(*) as total  FROM questions_projects WHERE pro_code='".$rowsqlpro['pro_code']."'");
            $rowtque = mysqli_fetch_array($sqltque);
            for ($i = 1; $i <= $rowtque['total']; $i++) {
                $pru = mysqli_query($conexion,"SELECT * FROM questions_projects WHERE pro_code='".$rowsqlpro['pro_code']."'");
                while ($rowpru = mysqli_fetch_array($pru)) {
                    if($rowproject3<>$questionget){
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="startprojects.php?quest='.$rowpru['que_code'].'&email='.$email.'&project='.$projectg.'"><span class="btn btn-success">'.$i++.'</a></span>';
                    }else{
                        echo 'sssdsdsd';
                    }

                }
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        /************* END  VALIDATION QUESTION AND PROJECT FOR COMMENTARY************
         *****************************************************************************/
    }else{
        echo 'connection fail';
    }
}else{
    header('Location: logout.php');
}
?>
</div>
<script type="text/javaScript">
    function answer_questions() {
        var total_answer =<?php echo $rowproject2['total_ans']?>;
        var question =<?php echo $que?>;
        var email = '<?php echo $email?>';
        var project = '<?php echo $projectg?>';
        var optionalvalor = document.getElementById('optionalvalor').value;
        if (total_answer == 1) {
            var valor1 = document.getElementById('valor1').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 2) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 3) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 4) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            var valor4 = document.getElementById('valor4').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;

        } else if (total_answer == 5) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            var valor4 = document.getElementById('valor4').value;
            var valor5 = document.getElementById('valor5').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 6) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            var valor4 = document.getElementById('valor4').value;
            var valor5 = document.getElementById('valor5').value;
            var valor6 = document.getElementById('valor6').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 7) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            var valor4 = document.getElementById('valor4').value;
            var valor5 = document.getElementById('valor5').value;
            var valor6 = document.getElementById('valor6').value;
            var valor7 = document.getElementById('valor7').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 8) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            var valor4 = document.getElementById('valor4').value;
            var valor5 = document.getElementById('valor5').value;
            var valor6 = document.getElementById('valor6').value;
            var valor7 = document.getElementById('valor7').value;
            var valor8 = document.getElementById('valor8').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 9) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            var valor4 = document.getElementById('valor4').value;
            var valor5 = document.getElementById('valor5').value;
            var valor6 = document.getElementById('valor6').value;
            var valor7 = document.getElementById('valor7').value;
            var valor8 = document.getElementById('valor8').value;
            var valor9 = document.getElementById('valor9').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else if (total_answer == 10) {
            var valor1 = document.getElementById('valor1').value;
            var valor2 = document.getElementById('valor2').value;
            var valor3 = document.getElementById('valor3').value;
            var valor4 = document.getElementById('valor4').value;
            var valor5 = document.getElementById('valor5').value;
            var valor6 = document.getElementById('valor6').value;
            var valor7 = document.getElementById('valor7').value;
            var valor8 = document.getElementById('valor8').value;
            var valor9 = document.getElementById('valor9').value;
            var valor10 = document.getElementById('valor10').value;
            //var optionalvalor = document.getElementById('optionalvalor').value;
        } else {
            console.log('dsssds');
        }
        if (total_answer == 1) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 2) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 3) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 4) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "valor4": valor4,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 5) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "valor4": valor4,
                "valor5": valor5,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 6) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "valor4": valor4,
                "valor5": valor5,
                "valor6": valor6,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 7) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "valor4": valor4,
                "valor5": valor5,
                "valor6": valor6,
                "valor7": valor7,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 8) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "valor4": valor4,
                "valor5": valor5,
                "valor6": valor6,
                "valor7": valor7,
                "valor8": valor8,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 9) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "valor4": valor4,
                "valor5": valor5,
                "valor6": valor6,
                "valor7": valor7,
                "valor8": valor8,
                "valor9": valor9,
                "optionalvalor":optionalvalor,
            };
        } else if (total_answer == 10) {
            var parametros = {
                "question": question,
                "email": email,
                "project": project,
                "valor1": valor1,
                "valor2": valor2,
                "valor3": valor3,
                "valor4": valor4,
                "valor5": valor5,
                "valor6": valor6,
                "valor7": valor7,
                "valor8": valor8,
                "valor9": valor9,
                "valor10": valor10,
                "optionalvalor":optionalvalor,
            };
        } else {
        }
        $.ajax({
            data: parametros,
            url: "../ajax/ajax.answer_questions.php",
            type: "post",
            beforeSend: function () {
                $("#resultadoval").html("Procesando");
                console.log();
            },
            success: function (response) {
                $("#resultadoval").html(response);
            }
        });
    }
    $(document).ready(function () {
        $("#hide").on('click', function () {
            $("#element").hide();
            return false;
        });
        $("#show").on('click', function () {
            $("#element").show();
            return false;
        });
    });
</script>
</body>
</html>
