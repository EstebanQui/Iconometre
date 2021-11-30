<?php
if (isset($_GET['term'])){
	require_once '../controllers/connection.php';
	$return_arr = array();
	$fetch = mysqli_query($conexion,"SELECT DISTINCT ans_description FROM answers_questions where ans_description like '%" . mysqli_real_escape_string($conexion,($_GET['term'])) . "%' LIMIT 0 ,50"); 	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {		
		$row_array['value'] = $row['ans_description'];	
        $row_array['answer']=$row['ans_description']; 				
		array_push($return_arr,$row_array);
    }
echo json_encode($return_arr);
}
?>