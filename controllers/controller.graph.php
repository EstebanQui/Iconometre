<?php
require_once "connection.php";
$project = $_GET['project'];

/* Declare an array containing our data points */
$data_points = array();

/* Usual SQL Queries */
$query = "SELECT
	format(SUM(t.tmp_valoration) / count(t.usr_code),2) AS suma,a.ans_code,ans_correct,
	CASE WHEN a.ans_description = '' THEN 'Answer Added'
	ELSE a.ans_description END AS ans_description, q.que_code, q.que_description, p.pro_code, p.pro_subject
	FROM tmp_answers t, answers_questions a, questions_projects q, projects p
	WHERE t.ans_code = a.ans_code AND a.que_code = q.que_code AND q.pro_code = p.pro_code AND p.pro_code=$project
 	and a.ans_correct=100
	GROUP BY ans_code";
$result = mysqli_query($conexion, $query);

while ($row = mysqli_fetch_array($result)) {
	/* Push the results in our array */

	$point = array("ts" => $row['que_description'], "d1" => $row['suma']);

	array_push($data_points, $point);

}

/* Encode this array in JSON form */
echo json_encode($data_points, JSON_NUMERIC_CHECK);

mysqli_close($conexion);
?>