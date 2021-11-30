<?php
require_once '../controllers/connection.php';
require_once 'header.php';
$question = $_GET['quest'];

//********* */
$sql = mysqli_query($conexion, "SELECT q.que_code, q.que_description,q.que_image, p.pro_code, p.pro_name, p.pro_subject, p.pro_status
FROM questions_projects  q, projects p WHERE  q.pro_code=p.pro_code AND q.que_code=$question");
$rowsql = mysqli_fetch_array($sql);
//********** */

//********** LIST ANSWERS FOR QUESTIONS */

$sqlans=mysqli_query($conexion,"SELECT a.ans_code,a.ans_description,q.que_code,q.que_description,p.pro_code,p.pro_name
FROM answers_questions a, questions_projects q, projects p
WHERE a.que_code=q.que_code AND q.pro_code=p.pro_code AND q.que_code=$question AND p.pro_code='".$rowsql['pro_code']."'");
//********** */

//********** QUERY USER */
$user = mysqli_query($conexion, "SELECT * FROM iconometer_users WHERE usr_email='" . $_SESSION['email'] . "'");
$rowuser = mysqli_fetch_array($user);
//********** */


//INSERT TABLE TMP
$select=mysqli_query($conexion,"SELECT * FROM tmp_answers
RIGHT JOIN answers_questions ON tmp_answers.ans_code=answers_questions.ans_code
WHERE tmp_answers.usr_code ='' OR tmp_answers.usr_code is null AND que_code='".$question."'");
$rowsel=mysqli_fetch_array($select);    
$valtmp=mysqli_query($conexion,"SELECT * FROM tmp_answers WHERE usr_code='".$rowuser['usr_code']."' ");
if(mysqli_num_rows($valtmp)>0){    
    $sqlverif=mysqli_query($conexion,"SELECT * FROM answers_questions where que_code='$question'");
    foreach($sqlverif as $rows){
        $sqllist=mysqli_query($conexion,"SELECT * FROM tmp_answers WHERE ans_code='".$rows['ans_code']."' AND usr_code='".$rowuser['usr_code']."'");
        if(mysqli_num_rows($sqllist)>0){
        }else{
            $saveq = mysqli_query($conexion, "SELECT a.ans_code, a.ans_description, a.ans_valoration, a.ans_persons, q.que_code,
            q.que_description, p.pro_code, p.pro_subject, p.pro_status FROM answers_questions a, questions_projects q, projects p
            WHERE  a.que_code=q.que_code  AND q.pro_code=p.pro_code AND p.pro_code ='".$rowsql['pro_code']."'");        
            foreach ($saveq as $values) {
                $querys   = mysqli_query($conexion, "INSERT INTO tmp_answers VALUES (null,'".$values['ans_code']."','0','".$rowuser['usr_code']."')");
                
                if($querys>0){
                
                }else{
                   echo 'error ';
                }
            }       
        }
    }   
}else{
   $saveq = mysqli_query($conexion, "SELECT a.ans_code, a.ans_description, a.ans_valoration, a.ans_persons, q.que_code,
   q.que_description, p.pro_code, p.pro_subject, p.pro_status FROM answers_questions a, questions_projects q, projects p
   WHERE  a.que_code=q.que_code  AND q.pro_code=p.pro_code AND p.pro_code ='".$rowsql['pro_code']."'");
   foreach ($saveq as $value) {
     $query   = mysqli_query($conexion, "INSERT INTO tmp_answers VALUES (null,'".$value['ans_code']."','0','".$rowuser['usr_code']."')");
     if($query>0){
        
     }else{
        echo 'error ';
     }
   }
}
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<style>
	#content{
		position: absolute;
		min-height: 50%;
		width: 80%;
		top: 20%;
		left: 5%;
	}

	.selected{
		cursor: pointer;
	}
	.selected:hover{
		background-color: green;
		color: white;
	}
	.seleccionada{
		background-color: green;
		color: white;
	}
   
</style>
<script language="JavaScript" >

//window.onerror = new Function("return true")

</script> 
<div class="content-wrapper">
   <section class="content">
      <div class="box">
         <div class="box-body">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12">
                     <form  role="form"  class="form-inline">
                     <fieldset>
                     <legend>Details Test:</legend>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Project Name</label>
                              <input type="text" class="form-control" name="project" value="<?php echo $rowsql['pro_name'] ?>" id="project" readonly="" />
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Project Subject</label>
                              <input type="text" class="form-control" name="subject" value="<?php echo $rowsql['pro_subject'] ?>" id="subject" readonly="" />
                           </div>
                           <div class="form-group">
                           </div>
                     </fieldset>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="box">
         <div class="box-body">
            <div class="container-fluid">
               <center>
                    <div class="row">
                    <fieldset>
                    <legend><?php echo $rowsql['que_description']?></legend>

                    <p class="indication">Please distribute 100 points between each answer or write your own with the ADD ANSWER button and add your points</p>

                    <div class="col-md-12">                
                        <div class="row">                        
                            <div class="col-md-6">
                                <img id="myImg" class="rounded mx-auto d-block" src="../images/<?php echo $rowsql['que_image']?>" width="200"/>
                                    <p>
                                        <button type="button" onclick="agrandir()"> + </button>
                                        <button type="button" onclick="diminuer()"> - </button>
                                    </p>
                            </div>
                            <div class="col-md-6">
                                <table id="tabla" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Value</th>
                                            <th>Answers</th>                                            								
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totanswer = mysqli_query($conexion,"SELECT count(*) AS total_answer FROM tmp_answers t,  answers_questions a,
                                        questions_projects q,   iconometer_users u WHERE   t.ans_code = a.ans_code AND a.que_code = q.que_code AND t.usr_code = u.usr_code
                                        AND q.que_code = '$question' AND u.usr_code='".$rowuser['usr_code']."' AND q.pro_code='".$rowsql['pro_code']."'");                        
                                        $rowtotal  = mysqli_fetch_array($totanswer);
                                        for ($i = 1; $i <= $rowtotal['total_answer']; $i++) {
                                            $sqlanswer = mysqli_query($conexion,"SELECT t.tmp_code, t.tmp_valoration as valoration, a.ans_code, a.ans_description, q.que_code,
                                            q.que_description,u.usr_code, u.usr_email FROM tmp_answers t, answers_questions a, questions_projects q, iconometer_users u
                                            WHERE t.ans_code=a.ans_code and a.que_code=q.que_code AND t.usr_code=u.usr_code
                                            AND q.que_code='$question' AND u.usr_code='".$rowuser['usr_code']."' AND q.pro_code='".$rowsql['pro_code']."'");
                                            while($rowans=mysqli_fetch_array($sqlanswer)){                                            
                                                echo '<tr>';
                                                echo '<td><input type="text" class="form-control" name="valor" id="valor'.$i++.'" size="2" value="'.$rowans['valoration'].'" onblur="answer_questions()"></td>';                                
                                                echo '<td><input  type="text" class="form-control"  value="'.$rowans['ans_description'].'" readonly></td>';                             
                                                echo '</tr>';
                                            } 
                                        }                                                                               
                                        echo'<button id="bt_add" class="btn btn-default">Add Answers</button>';
                                        echo'<button id="bt_del" class="btn btn-default">Del Answers</button>';
                                        //echo '<input type="button" value="Capturar" onclick="Capturar()">';
                                        ?>						
                                    </tbody>                                
                                </table>
                                <div id="resultadoval"></div>
                                <?php 
                                //
                                $sqltque = mysqli_query($conexion,"SELECT count(*) as total  FROM questions_projects WHERE pro_code='".$rowsql['pro_code']."'");
                                $rowtque = mysqli_fetch_array($sqltque);
                                //
                                for ($i = 1; $i <= $rowtque['total']; $i++) {
                                    $pru = mysqli_query($conexion,"SELECT * FROM questions_projects WHERE pro_code='".$rowsql['pro_code']."'");                                    
                                    echo '<nav aria-label="Page navigation example">';
                                    echo '<ul class="pagination justify-content-center">';
                                    while ($rowpru = mysqli_fetch_array($pru)) {
                                        if($rowtque<>$question){
                                            echo '<li class="page-item"><a href="start_projects.php?quest='.$rowpru['que_code'].'&email='.$rowuser['usr_email'].'&project='.$rowsql['pro_code'].'" class="page-link">'.$i++.'</a></li>';
                                        }else{
                                            echo 'sssdsdsd';
                                        }            
                                    }
                                    echo '</ul>';
                                    echo '</nav>';
                                }
                                
                                //
                                $totanswer2 = mysqli_query($conexion,"SELECT count(*) AS total_answer FROM tmp_answers t,  answers_questions a,
                                questions_projects q,   iconometer_users u WHERE   t.ans_code = a.ans_code AND a.que_code = q.que_code AND t.usr_code = u.usr_code
                                AND q.que_code = '$question' AND u.usr_code='".$rowuser['usr_code']."' AND q.pro_code='".$rowsql['pro_code']."'");  
                                $rowtanswer=mysqli_fetch_array($totanswer2);
                                ?>  
                            </div>  
                        </div>     
                    </div>
                </center>               	
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<script>
$(document).ready(function(){
		$('#bt_add').click(function(){
			agregar();
		});
		$('#bt_del').click(function(){
			eliminar(id_fila_selected);
		});
		/*$('#bt_delall').click(function(){
			eliminarTodasFilas();
		});*/		
	});
var cont=<?php echo $rowtanswer['total_answer']?>;
var id_fila_selected=[];
function agregar(){
	cont++;
	var fila='<tr class="selected" id="fila" onclick="seleccionar(this.id);"><td><input type="text" class="form-control" name="valor" size="2" id="valor'+cont+'" onblur="answer_questions()"></td><td><input type="text" class="form-control"></td></tr>';
	$('#tabla').append(fila);
	reordenar();
}
function seleccionar(id_fila){
	if($('#'+id_fila).hasClass('seleccionada')){
		$('#'+id_fila).removeClass('seleccionada');
	}
	else{
		$('#'+id_fila).addClass('seleccionada');
	}
	//2702id_fila_selected=id_fila;
	id_fila_selected.push(id_fila);
}
function eliminar(id_fila){
	$('#'+id_fila).remove();
	reordenar();
	for(var i=0; i<id_fila.length; i++){
		$('#'+id_fila[i]).remove();
	}
	reordenar();
}
function reordenar(){
	var num=1;
	$('#tabla tbody tr').each(function(){
		$(this).find('td').eq(2).text(num);
		num++;
	});
}
function eliminarTodasFilas(){
    $('#tabla tbody tr').each(function(){
            $(this).remove();
        });
}
function answer_questions() {

    //var total_answer =<?php echo $rowtanswer['total_answer']?>;
    var question =<?php echo $question?>;
    var email = '<?php echo $rowuser['usr_email']?>';
    var project = '<?php echo $rowsql['pro_code']?>';
    
    if(document.getElementById("valor1")){
        var valor1 = document.getElementById('valor1').value;
    }if(document.getElementById("valor2")){
        var valor2 = document.getElementById('valor2').value;
    }if(document.getElementById("valor3")){
        var valor3 = document.getElementById('valor3').value;
    }if(document.getElementById("valor4")){
        var valor4 = document.getElementById('valor4').value;
    }if(document.getElementById("valor5")){
        var valor5 = document.getElementById('valor5').value;
    }if(document.getElementById("valor6")){
        var valor6 = document.getElementById('valor6').value;
    }if(document.getElementById("valor7")){
        var valor7 = document.getElementById('valor7').value;
    }if(document.getElementById("valor8")){
        var valor8 = document.getElementById('valor8').value;
    }if(document.getElementById("valor9")){
        var valor9 = document.getElementById('valor9').value;
    }if(document.getElementById("valor10")){
        var valor10 = document.getElementById('valor10').value;
    }
    var parametros = {
        "question": question,"email": email,"project": project,"valor1": valor1, "valor2": valor2,"valor3": valor3,
        "valor4": valor4,"valor5": valor5,"valor6": valor6,"valor7": valor7, "valor8": valor8,"valor9": valor9,"valor10": valor10,
    };
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
function agrandir() {
    var myImg = document.getElementById("myImg");
    var width = myImg.clientWidth;
    if (width == 400) {
        alert("Vous avez atteint le niveau de zoom maximal.");
    } else {
        myImg.style.width = (width + 20) + "px";
    }
}
function diminuer() {
    var myImg = document.getElementById("myImg");
    var width = myImg.clientWidth;
    if (width == 200) {
        alert("Vous avez atteint le niveau de zoom minimal.");
    } else {
        myImg.style.width = (width - 20) + "px";
    }
}    
</script>