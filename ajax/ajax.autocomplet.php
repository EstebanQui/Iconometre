<style>
	#suggestions {
    box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
    height: auto;
    position: absolute;
    top: 370px;
    z-index: 9999;
    width: 206px;
}
 
#suggestions .suggest-element {
    background-color: #EEEEEE;
    border-top: 1px solid #d6d4d4;
    cursor: pointer;
    padding: 8px;
    width: 100%;
    float: left;
}
</style>
<?php
error_reporting(0);
include '../controllers/connection.php';
$html = '';
$key = array($_POST['answer1'],$_POST['answer2'],$_POST['answer3'],$_POST['answer4'],$_POST['answer5'],$_POST['answer6'],$_POST['answer7'],$_POST['answer8'],$_POST['answer9'],$_POST['answer10']);
$longitud = count($key);
for ($i = 0; $i < $longitud; $i++){
	echo $listval = $key[$i++];
	$result=mysqli_query($conexion,'SELECT * FROM answers_questions WHERE ans_description LIKE "%'.$listval.'%" LIMIT 0,5');
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {                
		        $html .= '<div class="suggest-element"><a class="suggest-element" data="'.$row['ans_description'].'" id="'.$row['ans_code'].'">'.$row['ans_description'].'</a></div>';                 
		}
	}else{
		echo 'nD';
	}
}
echo $html;

?>