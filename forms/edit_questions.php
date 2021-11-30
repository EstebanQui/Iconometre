<?php 
require_once '../controllers/connection.php';
$sqlqu=mysqli_query($conexion,"SELECT * FROM questions_projects WHERE que_code='".$row['que_code']."'");
$rowque=mysqli_fetch_array($sqlqu);
?>
<div class="modal fade" id="modaleditquestions<?php echo $rowque['que_code']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form  role="form" action="../controllers/controller.projects.php" method="POST" enctype="multipart/form-data">                    
        <div class="form-group">
           <label for="exampleInputEmail1">Question</label>
           <input type="text" class="form-control" name="question" id="question" value="<?php echo $rowque['que_description']?>" />
           <input type="hidden" class="form-control" name="codequestion" id="codequestion" value="<?php echo $rowque['que_code']?>" />
           <input type="hidden" class="form-control" name="project" id="project" value="<?php echo $rowque['pro_code']?>" />
        </div>
        <div class="form-group">
	        <label for="exampleInputEmail1">Image</label>
            <div class="custom-file">
                <?php                 
                echo'<img class=" icon img-fluid img-thumbnail" src="../images/' . $rowque['que_image'] . '" width="75">';
                echo'<input type="hidden" class="form-control" name="imageque" id="imageque" value="'.$rowque['que_image'].'" />';
                ?>
            </div>
	    </div>
        <div class="form-group">
	        <label for="exampleInputEmail1">Change Image</label>
            <div class="custom-file">
                <input type="file" name="imagenew" id="imagenew" class="custom-file-input" id="customFile">
                <img id="preview" class="w-50 img-fluid">
            </div>
	    </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit_editquestions" class="btn btn-success">Update changes</button>
      </div>
      </form>
    </div>
  </div>
</div>