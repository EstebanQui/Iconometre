<?php 
require_once '../controllers/connection.php';
$sqlpr=mysqli_query($conexion,"SELECT * FROM projects WHERE pro_code='".$row['pro_code']."'");
$rowpro=mysqli_fetch_array($sqlpr);
?>
<div class="modal fade" id="modaleditproject<?php echo $row['pro_code']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
           <input type="text" class="form-control" name="project" id="project" value="<?php echo $rowpro['pro_name']?>" />
           <input type="hidden" class="form-control" name="projectcode" id="projectcode" value="<?php echo $rowpro['pro_code']?>" />
        </div>
        <div class="form-group">
           <label for="exampleInputEmail1">Project Subject</label>
           <input type="text" class="form-control" name="subject" id="subject"value="<?php echo $rowpro['pro_subject']?>" />
        </div>             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit_editproject" class="btn btn-success">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>