<?php
require_once "connection.php";
$project = $_GET['project'];

/* Declare an array containing our data points */
$data_points = array();

/* Usual SQL Queries */
$query  = "SELECT
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
p.pro_code";
$result = mysqli_query($conexion, $query);

while ($row = mysqli_fetch_array($result)) {
    /* Push the results in our array */
    $point = array("ts" => $row['moyenne'], "d1" => $row['moyenne']);
    array_push($data_points, $point);
}

/* Encode this array in JSON form */
echo json_encode($data_points, JSON_NUMERIC_CHECK);

mysqli_close($conexion);
?>