<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iconometre Stats</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/canvas.min.js"></script>
</head>
<body>
<div class="cols">
    <div id="chartContainer" class="col1">

    </div>
</div>
<?php
require_once '../controllers/connection.php';
$project = $_GET['project'];
//QUERY TOTAL QUESTIONS
$questiont = mysqli_query($conexion, "SELECT count(*) as total_questions FROM questions_projects WHERE pro_code=$project order by que_code desc");
$rowquestotal = mysqli_fetch_array($questiont);

//pru
$codq = mysqli_query($conexion, "SELECT * FROM questions_projects WHERE pro_code=$project");
$rowqc = mysqli_fetch_array($codq);

$question = mysqli_query($conexion, "SELECT que_code, que_description,que_image, pro_code FROM questions_projects WHERE pro_code=$project GROUP BY que_code");

// total asnwers
$totalans = mysqli_query($conexion, "SELECT  COUNT(*) AS total_answer FROM answers_questions a, questions_projects q
WHERE q.que_code = a.que_code AND q.pro_code = $project AND q.que_code = '" . $rowqc['que_code'] . "'");
$rowtotalans = mysqli_fetch_array($totalans);

///personas respondieron
$usrtest = mysqli_query($conexion, "SELECT  DISTINCT COUNT(a.ans_persons)  as total_users  FROM tmp_answers t INNER JOIN answers_questions a ON a.ans_code = t.ans_code INNER JOIN questions_projects q ON q.que_code = a.que_code INNER JOIN projects p ON q.pro_code = p.pro_code INNER JOIN iconometer_users u ON t.usr_code = u.usr_code WHERE p.pro_code = $project and q.que_code = '" . $rowqc['que_code'] . "' GROUP BY a.ans_code");

//puntos des las repustas correcta o incorrecta
$pquestion = mysqli_query($conexion, "SELECT
    a.ans_correct,
    a.ans_description,
    p.pro_code,
    q.que_code,
    q.que_description
FROM
    answers_questions a,
    projects p,
    questions_projects q
WHERE
    q.pro_code = p.pro_code
AND q.que_code = a.que_code
AND p.pro_code = $project
and a.ans_correct <>0;");
$r1 = mysqli_fetch_array($pquestion);

for ($i = 0; $i <= $rowquestotal['total_questions']; $i++) {

	while ($rowquest = mysqli_fetch_array($question)) {

		?>
        <div class="container">
            <div class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading"><center><H2>Graphique <?php echo $rowquest['que_description']; ?><?php echo '<img src="../images/' . $rowquest['que_image'] . '">'; ?></center></div>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">
                                Average score: for each proposed meaning,the average of the score received by the testers is shown.<br>
                                Wrong meaning: meaning to which the admin assigned 0 points. <br>
                                Correct meaning: meaning to which the admin assigned more than 0 points. <br>
                                Comprehension degree: sum of the average scores of the correct meanings.</th>
                            <th scope="col" style="vertical-align: top;">
                                Red: Wrong meanings, <br>
                                Green: Correct meanings, <br>
                                Gray: undefined</th>
                            </tr>
                        </thead>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Numbers of testers</th>
                            <th scope="col">Total answers</th>
                            <th scope="col">Correct answers</th>
                            <th scope="col">incorrect answers</th>
                            <th scope="col">I dont know answers</th>
                        </thead>
                        <tbody>
                            <?php
foreach ($usrtest as $key => $value) {
			?>
                            <td><?php echo $value['total_users'] ?></td>
                            <?php
$totalans = mysqli_query($conexion, "select COUNT(t.usr_code)as total_answers
                                from tmp_answers t
                                inner join answers_questions a on t.ans_code=a.ans_code
                                inner join questions_projects q on a.que_code=q.que_code
                                inner join projects p on q.pro_code=p.pro_code
                                where a.ans_correct <> 0
                                and t.tmp_valoration >0
                                and p.pro_code =$project
                                and q.que_code ='" . $rowquest['que_code'] . "'
                                UNION
                                select COUNT(t.usr_code)as total_answers
                                from tmp_answers t
                                inner join answers_questions a on t.ans_code=a.ans_code
                                inner join questions_projects q on a.que_code=q.que_code
                                inner join projects p on q.pro_code=p.pro_code
                                where a.ans_correct = 0
                                and t.tmp_valoration >0
                                and p.pro_code =$project
                                and q.que_code ='" . $rowquest['que_code'] . "'
                                union
                                select COUNT(t.usr_code)as total_answers
                                from tmp_answers t
                                inner join answers_questions a on t.ans_code=a.ans_code
                                inner join questions_projects q on a.que_code=q.que_code
                                inner join projects p on q.pro_code=p.pro_code
                                where a.ans_description= 'I dont know'
                                and t.tmp_valoration >0
                                and p.pro_code =$project
                                and q.que_code ='" . $rowquest['que_code'] . "'");
			$total_an = 0;

			while ($rowresult = mysqli_fetch_array($totalans)) {
				$total_an += $rowresult['total_answers'];
			}

			?>
                            <td><?php echo $total_an ?></td>
                            <?php }?>
                            <?php
//TABLERO CORRECT ANSWERS
		$tblcorr = mysqli_query($conexion, "select COUNT(t.usr_code)as total_usersrep
                                from tmp_answers t
                                inner join answers_questions a on t.ans_code=a.ans_code
                                inner join questions_projects q on a.que_code=q.que_code
                                inner join projects p on q.pro_code=p.pro_code
                                where a.ans_correct <> 0
                                and t.tmp_valoration <>0
                                and p.pro_code =$project
                                and q.que_code ='" . $rowquest['que_code'] . "'");
		foreach ($tblcorr as $key => $values) {
			$por = ($values['total_usersrep'] / $total_an) * 100;
			?>
                            <td><?php echo $values['total_usersrep'] ?> / <?php echo $total_an ?> = <?php echo number_format($por, '2') ?>%</td>
                            <?php }?>
                            <?php
//TABLERO INCORRECT
		$tblinc = mysqli_query($conexion, "select COUNT(t.usr_code)as total_incorrect
                                from tmp_answers t
                                inner join answers_questions a on t.ans_code=a.ans_code
                                inner join questions_projects q on a.que_code=q.que_code
                                inner join projects p on q.pro_code=p.pro_code
                                where a.ans_correct = 0
                                and t.tmp_valoration >0
                                and p.pro_code =$project
                                and q.que_code ='" . $rowquest['que_code'] . "'");
		foreach ($tblinc as $key => $valuesin) {
			?>
                            <td><?php echo $valuesin['total_incorrect'] ?> / <?php echo $total_an ?> = <?php echo number_format($valuesin['total_incorrect'] / $total_an * 100, "2") ?>%</td>
                            <?php }?>
                            <?php
//TABLERO I DONT KNOW
		$tblidn = mysqli_query($conexion, "select COUNT(t.usr_code)as total_idn
                                from tmp_answers t
                                inner join answers_questions a on t.ans_code=a.ans_code
                                inner join questions_projects q on a.que_code=q.que_code
                                inner join projects p on q.pro_code=p.pro_code
                                where a.ans_description= 'I dont know'
                                and t.tmp_valoration >0
                                and p.pro_code =$project
                                and q.que_code ='" . $rowquest['que_code'] . "'");
		foreach ($tblidn as $key => $valuesi) {
			?>
                            <td><?php echo $valuesi['total_idn'] ?> / <?php echo $total_an ?> = <?php echo number_format($valuesi['total_idn'] / $total_an * 100, "2") ?>%<td>
                            <?php }?>
                        </tbody>

                    </table>

                </div>
                    <div class="panel-body">
                        <div id="chartContainer<?php echo $rowquest['que_code'] ?>" class="col2">
                            <script type="text/javascript">
                                $.getJSON("../controllers/controller.graph_individual.php?project=<?php echo $project ?>&question=<?php echo $rowquest['que_code'] ?>", function (result) {
                                    var dps<?php echo $rowquest['que_code'] ?>= [];
                                    console.log(result)
                                    //Insert Array Assignment function here
                                    for (var i = 0; i < result.length; i++) {
                                            //     dps<?php echo $rowquest['que_code'] ?>.push({
                                            //     "label": result[i].ts,
                                            //     "y":result[i].d1,
                                            // });

                                        if(<?php echo $rowquest['que_code'] ?> > 0 && result[i].correct > 0){
                                            dps<?php echo $rowquest['que_code'] ?>.push({
                                            "label": result[i].ts,
                                                "y":result[i].d1,
                                                color:"green",
                                                "indexLabel": "Score: 100", indexLabelFontColor: "orangered",
                                            });

                                        }else if(<?php echo $rowquest['que_code'] ?> > 0 && result[i].correct == 0){
                                            dps<?php echo $rowquest['que_code'] ?>.push({
                                             "label": result[i].ts,
                                                "y":result[i].d1,
                                                color:"red",
                                                "indexLabel": "Score: 0", indexLabelFontColor: "orangered",
                                            });
                                        }else{
                                            dps<?php echo $rowquest['que_code'] ?>.push({
                                                "label": result[i].ts,
                                                "y":result[i].d1,
                                                color:"grey",
                                                "indexLabel": "Score: 0", indexLabelFontColor: "orangered",
                                            });

                                        }


                                    }
                                    //Insert Chart-making function here
                                        var chart = new CanvasJS.Chart("chartContainer<?php echo $rowquest['que_code'] ?>", {
                                        zoomEnabled: true,
                                        panEnabled: true,
                                        animationEnabled: true,
                                        title: {
                                            //text: "Graphique <?php echo $rowquest['que_description']; ?>",
                                        },
                                        legend: {
                                            text: "Average score: for each proposed meaning.",
                                        },
                                        axisX: {
                                            title: "Proposed Meanings",
                                        },
                                        axisY: {
                                            title: "Average score",
                                            minimum: 0
                                        },
                                        data: [{
                                            type: "column",

                                            dataPoints:
                                            dps<?php echo $rowquest['que_code']; ?>,


                                        }]

                                    });
                                    chart.render();
                                });
                            </script>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <?php
echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
	}
}
?>
</body>
</html>