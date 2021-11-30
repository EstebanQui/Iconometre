<?php
require_once '../controllers/connection.php';
require_once 'header.php';
$question=$_GET['question'];


$sqlcid=mysqli_query($conexion,"SELECT * FROM answers_questions WHERE ans_description ='I dont know' and que_code='$question'");
if(mysqli_num_rows($sqlcid)>0){

}else{
   $sqlidn=mysqli_query($conexion,"INSERT INTO answers_questions VALUES (null,'I dont know','$question','','','0')");
}
$sqlpro=mysqli_query($conexion,"SELECT q.que_code,q.que_description,q.que_image, p.pro_code,p.pro_name FROM questions_projects q, projects p
WHERE q.pro_code=p.pro_code AND q.que_code =$question");
$rowq=mysqli_fetch_array($sqlpro);
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="../js/varios.js"></script>
<div class="content-wrapper">
   <section class="content">
   
      <div class="box">
         <div class="box-body">
            <div class="container-fluid">
               <div class="row">               
                  
                  <div class="col-md-12">
                     <form  role="form" action="../controllers/controller.projects.php" method="POST" class="form-inline">
                     <fieldset>
                        <legend>Create Answers Question: <?php echo $rowq['que_description']?> -- Project: <?php echo $rowq['pro_name']?> </legend>
                           <div class="form-group">
                              <img src="../images/<?php echo $rowq['que_image']?>" class="img-thumbnail" width="50px">
                           </div>

                           <div class="form-group">
                              <label for="codigoquestion">Question</label>
                              <input type="text" class="form-control" name="question" id="question" value="<?php echo $rowq['que_description']?>" readonly/>
                              <input type="hidden" class="form-control" name="codigoquestion" id="codigoquestion" value="<?php echo $rowq['que_code']?>" readonly/>
                           </div>
                           <div class="form-group">
                              <label for="" class="form-label">Answer</label>
                              <!-- default answer -->
                              <input type="text" class="form-control is-valid" name="answer" id="answer" required/>
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Value</label>
                              <input type="text" class="form-control" name="valoration" id="valoration" />
                           </div>
                           
                           <button type="submit" name="submit_answers" class="btn btn-success">Add Answer</button>
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
               <div class="row">
               <fieldset>
               <ul class="pager">
                  <li> <a href="../views/create_questions.php?project=<?php echo $rowq['pro_code']?>" class="previous" style="color:#3c8dbc" role="button">&laquo; Previous</a></li>
               </ul>
              
               <legend>List Answers:</legend>
                  <table id="example" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                     <thead>
                        <tr>
                           <th>Answer</th>
                           <th>Value</th>
                           <th>Edit</th>
                           <th>Delete</th>                           
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $sql=mysqli_query($conexion,"SELECT * FROM answers_questions WHERE que_code=$question");
                        while ($row = mysqli_fetch_array($sql)) {
                           echo '<tr>';
                           echo '<td>' . $row['ans_description'] . '</td>';
                           echo '<td>' . $row['ans_correct'] . '</td>';
                           echo '<td><a href="#modaleditanswers'.$row['ans_code'].'" data-toggle="modal"><center><img src="../images/editar.png" class="img-thumbnail" width="40"></center></a></td>';
                           echo '<td><a href="../controllers/controller.projects.php?deleteanswers=' . $row['ans_code'] . '"><img src="../images/eliminar.png" class="img-thumbnail" width="40"></a></td>';
                           include '../forms/edit_answers.php';
                        }
                        ?>
                     </tbody>
                  </table>
               </fieldset>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<script>
   $(document).ready(function() {
       $('#example').DataTable({

           "language": {
               "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json"
           }
       });
   });
</script>

