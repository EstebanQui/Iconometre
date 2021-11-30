<?php
include '../controllers/connection.php';
$project = $_GET['project'];
$sql = mysqli_query($conexion, "SELECT
    format(SUM(t.tmp_valoration) / count(t.usr_code),2) AS suma,a.ans_code,ans_correct,
    CASE WHEN a.ans_description = '' THEN 'Answer Added'
    ELSE a.ans_description END AS ans_description, q.que_code, q.que_description, p.pro_code, p.pro_subject
    FROM tmp_answers t, answers_questions a, questions_projects q, projects p
    WHERE t.ans_code = a.ans_code AND a.que_code = q.que_code AND q.pro_code = p.pro_code AND p.pro_code=$project
    and a.ans_correct=100
    GROUP BY ans_code");

$sumai = 0; // y las otras variables que deseas que se sumen
foreach ($sql as $key) {
	$sumai = $sumai + $key['suma'];
}

$total_users = mysqli_query($conexion, "select COUNT(DISTINCT t.usr_code) as users, a.ans_code,q.que_code,p.pro_code
from tmp_answers t, answers_questions a, questions_projects q, projects p
where t.ans_code=a.ans_code and a.que_code=q.que_code and q.pro_code=p.pro_code
and p.pro_code=$project");
$rowtotal = mysqli_fetch_array($total_users);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iconometre Stats</title>
</head>
<body>
<div class="cols">
    <div id="chartContainer" class="col1">

    </div>
</div>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/canvas.min.js"></script>
<script type="text/javascript">
    $.getJSON("../controllers/controller.graph.php?project=<?php echo $project ?>", function (result) {
        var dps1 = [];

//Insert Array Assignment function here
        for (var i = 0; i < result.length; i++) {
            dps1.push({"label": result[i].ts, "y": result[i].d1,color:"green"});

        }

//Insert Chart-making function here
        var chart = new CanvasJS.Chart("chartContainer", {
            zoomEnabled: true,
            panEnabled: true,
            animationEnabled: true,
            title: {
                text: "Graphique d'evocation",

            },

            axisX: {
                    title: "Specific Weight <?php echo number_format(($sumai / $rowtotal['users']), 2, '.', ''); ?>%",

            },

            axisY: {
                title: "Average",
                minimum: 0
            },

            data: [{
                type: "column",

                dataPoints:
                dps1
            }]

        });
        chart.render();

    });
</script>

</body>
</html>