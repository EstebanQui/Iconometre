<?php
include '../controllers/connection.php';
$project = $_GET['project'];
$sql=mysqli_query($conexion,"SELECT
	q.que_code,
	p.pro_name,
	t.ans_code,
	t.tmp_valoration,
	t.usr_code,
	a.ans_correct,
	COUNT(t.usr_code) AS total_user,
	SUM(t.tmp_valoration) AS TOTAL_val,
	SUM(t.tmp_valoration) / COUNT(t.usr_code) AS moyenne
FROM
	tmp_answers t,
	answers_questions a,
	questions_projects q,
	projects p
WHERE
	t.ans_code = a.ans_code
AND t.tmp_valoration <> 0
AND a.ans_correct <> 0
AND a.que_code = q.que_code
AND q.pro_code = p.pro_code
AND p.pro_code ='$project'
GROUP BY
	p.pro_code");
$row=mysqli_fetch_array($sql);

/*$sumai =0; // y las otras variables que deseas que se sumen
foreach ($sql as $key ) {
    $sumai = $sumai + $key['peso_especifico'];
} */
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
    $.getJSON("../controllers/controller.graph_final.php?project=<?php echo $project?>", function (result) {
        var dps1 = [];

//Insert Array Assignment function here
        for (var i = 0; i < result.length; i++) {
            dps1.push({"label": result[i].ts, "y": result[i].d1});
        }

//Insert Chart-making function here
        var chart = new CanvasJS.Chart("chartContainer", {
            zoomEnabled: true,
            panEnabled: true,
            animationEnabled: true,
            title: {
                text: "Graphique Final",
                
            },

            axisX: {
                    title: "Specific Weight <?php echo $row['moyenne']; ?>"
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