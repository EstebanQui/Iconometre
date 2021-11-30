<?php
require_once "../controllers/connection.php"
$project  = $_GET['project'];
$question = $_GET['question'];
//query questions
$question = mysqli_query($conexion, "SELECT * FROM questions_projects WHERE pro_code=$project and que_code=$question");
$rowquest = mysqli_fetch_array($question);
/* Declare an array containing our data points */
$data_points = array();

/* Usual SQL Queries */
$query  = "SELECT
	format(
		SUM(t.tmp_valoration) / count(t.usr_code),
		2
	) AS suma,
	a.ans_code,
	CASE
WHEN a.ans_description = '' THEN
	'Answer Added'
ELSE
	a.ans_description
END AS ans_description,
	q.que_code,
	q.que_description,
	p.pro_code,
	p.pro_subject
   ans_correct
FROM
	tmp_answers t,
	answers_questions a,
	questions_projects q,
	projects p
WHERE
	t.ans_code = a.ans_code
AND a.que_code = q.que_code
AND q.pro_code = p.pro_code
AND p.pro_code='7'
AND q.que_code= q.que_code
GROUP BY
	ans_code";
$result = mysqli_query($conexion, $query);

while ($row = mysqli_fetch_array($result)) {
    /* Push the results in our array */
    $point = array("ts" => $row['ans_description'], "d1" => $row['suma']);
    array_push($data_points, $point);
}

/* Encode this array in JSON form */
echo json_encode($data_points, JSON_NUMERIC_CHECK);

mysqli_close($conexion);
?>
<!DOCTYPE HTML>
<html>
<head>  
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>