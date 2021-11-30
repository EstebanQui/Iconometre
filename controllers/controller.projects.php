<?php
require_once 'connection.php';
error_reporting(0);

if (isset($_POST['submit_project'])) {
	$name = $_POST['project'];
	$subj = $_POST['subject'];
	$stat = $_POST['status'];
	$sql = mysqli_query($conexion, "INSERT INTO projects VALUES(null,'$name','$subj',now(),'$stat')");
	if ($sql > 0) {
		header('Location: ../views/projects.php');
	} else {
		echo 'Fail';

	}
} elseif (isset($_GET['statusa'])) {
	$project = $_GET['pro_code'];

	$sqld = mysqli_query($conexion, "UPDATE projects SET pro_status=0 WHERE pro_code='$project' AND pro_status=1");
	if ($sqld > 0) {
		header('Location: ../views/projects.php');
	} else {
		echo 'Fail no desactivado';
	}
} elseif (isset($_GET['statusi'])) {
	$project = $_GET['pro_code'];

	$sqla = mysqli_query($conexion, "UPDATE projects SET pro_status=1 WHERE pro_code='$project' AND pro_status=0");
	if ($sqla > 0) {
		header('Location: ../views/projects.php');
	} else {
		echo 'Fail no nactivado';
	}
} elseif (isset($_POST['submit_editproject'])) {
	$codeproject = $_POST['projectcode'];
	$nameproject = $_POST['project'];
	$subjectproject = $_POST['subject'];

	$sqla = mysqli_query($conexion, "UPDATE projects SET pro_name='$nameproject', pro_subject='$subjectproject' WHERE pro_code='$codeproject'");
	if ($sqla > 0) {
		header('Location: ../views/projects.php');
	} else {
		echo 'Fail no Update';
	}

} elseif (isset($_GET['delete'])) {
	$dele = mysqli_query($conexion, "DELETE FROM projects WHERE pro_code='" . $_GET['delete'] . "'" );
	
	if ($dele > 0) {
		header('Location: ../views/projects.php');
	} else {
		echo"<script type=\"text/javascript\">alert('¡ATTENTION! Project have questions'); history.back();</script>";
	}
//SAVE QUESTIONS
} elseif (isset($_POST['submit_questions'])) {
	$dir = "../images/";
	$nombreArchivo = $_FILES['image']['name'];
	$project = $_POST['project'];
	$questio = $_POST['question'];
	if (move_uploaded_file($_FILES['image']['tmp_name'], $dir . $nombreArchivo)) {
		$ques = mysqli_query($conexion, "INSERT INTO questions_projects VALUES (null,'$questio','$project','$nombreArchivo')");
		if ($ques > 0) {
			header("Location: ../views/create_questions.php?project=$project");
			//echo "../views/create_questions.php?project=$project";
		} else {
			echo 'Fail questions';
		}
	} else {
		echo 'error al subir la imagen';
	}
//EDIT QUESTIONS
} elseif (isset($_POST['submit_editquestions'])) {
	$dir = "../images/";
	$nombreArchivoe = $_FILES['imagenew']['name'];
	$questioe = $_POST['question'];
	$codequestion=$_POST['codequestion'];
	$project = $_POST['project'];
	if($_FILES['imagenew']['name'] != null) {
		if (move_uploaded_file($_FILES['imagenew']['tmp_name'], $dir . $nombreArchivoe)) {
			$ques = mysqli_query($conexion, "UPDATE questions_projects SET que_description='$questioe', que_image='$nombreArchivoe' WHERE que_code='$codequestion'");
			if ($ques > 0) {
				header("Location: ../views/create_questions.php?project=$project");
				//echo "../views/create_questions.php?project=$project";
			} else {
				echo 'Fail questions update';
			}
		} else {
				echo 'error al subir la imagesn';
		}
	}else{
		$ques = mysqli_query($conexion, "UPDATE questions_projects SET que_description='$questioe' WHERE que_code='$codequestion'");
		if ($ques > 0) {
			header("Location: ../views/create_questions.php?project=$project");
			//echo "../views/create_questions.php?project=$project";
		} else {
			echo 'Fail questions update';
		}
		
	}
//DELETE QUESTIONS
} elseif (isset($_GET['deletequestions'])) {
	$sqlpr=mysqli_query($conexion,'SELECT pro_code FROM questions_projects WHERE que_code="'.$_GET['deletequestions'].'"');
	$rowsqlpr=mysqli_fetch_array($sqlpr);
	$codeque=$rowsqlpr['pro_code'];
	$dele = mysqli_query($conexion, "DELETE FROM questions_projects WHERE que_code='" . $_GET['deletequestions'] . "'" );	
	if ($dele > 0) {
		header("Location: ../views/create_questions.php?project=$codeque");
	} else {
		echo"<script type=\"text/javascript\">alert('¡ATTENTION! Questions have Answers'); history.back();</script>";
	}
} elseif (isset($_POST['submit_answers'])) {
	/*$questions = $_POST['questions'];
	$_POST['answer1'];
	$_POST['answer2'];
	$_POST['answer3'];
	$_POST['answer4'];
	$_POST['answer5'];
	$_POST['answer6'];
	$_POST['answer7'];
	$_POST['answer8'];
	$_POST['answer9'];
	$_POST['answer10'];
	$_POST['answer11'];
	$_POST['answer12'];
	$_POST['answer13'];
	$_POST['answer14'];
	$_POST['answer15'];
	$_POST['answer16'];
	$_POST['answer17'];
	$_POST['answer18'];
	$_POST['answer19'];
	$_POST['answer20'];
	$_POST['optional'];
	$_POST['optionalcorrect'];
	$valores = array($_POST['answer1'], $_POST['answer2'], $_POST['answer3'], $_POST['answer4'], $_POST['answer5'], $_POST['answer6'], $_POST['answer7'], $_POST['answer8'], $_POST['answer9'], $_POST['answer10'], $_POST['answer11'], $_POST['answer12'], $_POST['answer13'], $_POST['answer14'], $_POST['answer15'], $_POST['answer16'], $_POST['answer17'], $_POST['answer18'], $_POST['answer19'], $_POST['answer20'], $_POST['optional']);
	$valoresc = array($_POST['correct1'], $_POST['correct2'], $_POST['correct3'], $_POST['correct4'], $_POST['correct5'], $_POST['correct6'], $_POST['correct7'], $_POST['correct8'], $_POST['correct9'], $_POST['correct10'], $_POST['correct11'], $_POST['correct12'], $_POST['correct13'], $_POST['correct14'], $_POST['correct15'], $_POST['correct16'], $_POST['correct17'], $_POST['correct18'], $_POST['correct19'], $_POST['correct20'], $_POST['optionalcorrect']);
	for ($i = 0; $i < count($valores); $i++) {
		foreach ($valoresc as $correct) {
			$sqlsaveans = mysqli_query($conexion, "INSERT INTO answers_questions VALUES (null,'" . $valores[$i++] . "','$questions','','','$correct')");
			if ($sqlsaveans > 0) {
				$delequ = mysqli_query($conexion, "DELETE FROM answers_questions WHERE ans_description='' AND que_code='$questions'");
				$sqlupo = mysqli_query($conexion, "UPDATE answers_questions SET ans_description='' WHERE ans_description='yourresponse' AND que_code='$questions'");
				header('Location: ../views/create_project.php');
			} else {
				echo 'not save';
			}
		}
	}*/
	$codequestion=$_POST['codigoquestion'];
	$answer=$_POST['answer'];
	$valoration=$_POST['valoration'];
	$sql=mysqli_query($conexion, "INSERT INTO answers_questions VALUES (null,'$answer','$codequestion','','','$valoration')");
	
	if($sql>0){
		header("Location: ../views/answers_questions.php?question=$codequestion");
	}else{
		//echo 'error';
		echo"<script type=\"text/javascript\">alert('¡please add value point!'); history.back();</script>";
	}
} elseif (isset($_POST['submit_editanswers'])) {	
	$codeanswer=$_POST['anscode'];
	$answer=$_POST['answer'];
	$valoration=$_POST['ans_valoration'];
	$question=$_POST['question'];
	$sql=mysqli_query($conexion, "UPDATE answers_questions SET ans_description='$answer', ans_correct='$valoration' WHERE ans_code='$codeanswer'");	
	if($sql>0){
		header("Location: ../views/answers_questions.php?question=$question");
	}else{
		echo 'error';
	}
} elseif (isset($_GET['deleteanswers'])) {	
	$sqlans=mysqli_query($conexion,'SELECT que_code FROM answers_questions WHERE ans_code="'.$_GET['deleteanswers'].'"');
	$rowsqlans=mysqli_fetch_array($sqlans);
	$codeans=$rowsqlans['que_code'];
	$dele = mysqli_query($conexion, "DELETE FROM answers_questions WHERE ans_code='" . $_GET['deleteanswers'] . "'" );	
	if ($dele > 0) {
		header("Location: ../views/answers_questions.php?question=$codeans");
	} else {
		echo"<script type=\"text/javascript\">alert('¡ATTENTION! Anwers Completed by User'); history.back();</script>";
	}
} elseif (isset($_POST['ans_codeu'])) {
	echo $answer = $_POST['answerdescri'];
	echo $answer = $_POST['anscorrect'];
	/*$sqlupans=mysqli_query($conexion,"UPDATE answers_questions SET ans_description='$answer', ans_correct='$valor' WHERE ans_code='".$_GET['ans_codeu']."'");
		    if($sqlupans>0){
		        header('Location: ../views/create_project.php');
		    }else{
		        echo 'Fail update answers';

	*/
} elseif (isset($_GET['ans_coded'])) {
	$ansdel = mysqli_query($conexion, "DELETE FROM answers_questions WHERE ans_code='" . $_GET['ans_coded'] . "'");
	if ($ansdel > 0) {
		header('Location: ../views/create_project.php');
	} else {
		echo 'Fail delete answers respon';
	}
} else if (isset($_POST['submit_comentary'])) {
	$comentary = $_POST['comentary'];
	$user = $_POST['user'];
	$project = $_POST['project'];
	$sql = mysqli_query($conexion, "INSERT INTO commentary VAlUES (null,'$user','$project','$comentary')");
	if ($sql > 0) {
		echo 'commentary save';
	} else {
		echo 'error no guardar comentario';
	}
} else {
	echo 'nada';
}
