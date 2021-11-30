<?php 
require_once '../controllers/connection.php';
$sqlans=mysqli_query($conexion,"SELECT * FROM answers_questions WHERE ans_code='".$row['ans_code']."'");
$rowans=mysqli_fetch_array($sqlans);
?>
<div class="modal fade" id="modaleditanswers<?php echo $row['ans_code']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form  role="form" action="../controllers/controller.projects.php" method="POST">                    
        <div class="form-group">
           <label for="exampleInputEmail1">Project Name</label>
           <input type="text" class="form-control" name="answer" id="answer" value="<?php echo $rowans['ans_description']?>" />
           <input type="hidden" class="form-control" name="anscode" id="anscode" value="<?php echo $rowans['ans_code']?>" />
           <input type="hidden" class="form-control" name="question" id="question" value="<?php echo $rowans['que_code']?>" />
        </div>
        <div class="form-group">
           <label for="exampleInputEmail1">Valoration</label>
           <input type="text" class="form-control" name="ans_valoration" id="ans_valoration"value="<?php echo $rowans['ans_correct']?>" />
        </div>             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit_editanswers" class="btn btn-success">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>