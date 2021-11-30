<?php
require_once '../controllers/connection.php';
require_once 'header.php';
$proget = $_GET['project'];
$sql = mysqli_query($conexion, "SELECT * FROM projects WHERE pro_code='" . $proget . "'");
$rowsql = mysqli_fetch_array($sql);
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript">
   $(document).ready(function (e) {
        $('input[type="file"]').on('change', (e) => {
            console.log('change file');
            let that = e.currentTarget
            if (that.files && that.files[0]) {
                $(that).next('.custom-file-label').html(that.files[0].name)
                let reader = new FileReader()
                reader.onload = (e) => {
                    $('#preview').attr('src', e.target.result)
                }
                reader.readAsDataURL(that.files[0])
            }
        })
    });
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
                     <legend>Project Name:</legend>
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
               <div class="row">               	                
                <div class="col-md-12">
	               	<form  role="form" action="../controllers/controller.projects.php" method="POST" class="form-inline" enctype="multipart/form-data">
                     <fieldset>
                     <legend>Create Questions</legend>
	               	  <input type="hidden" class="form-control" name="project" value="<?php echo $rowsql['pro_code'] ?>" id="project" readonly=""/>
	                    <div class="form-group">
	                       <label for="exampleInputEmail1">Question</label>
	                       <input type="text" class="form-control" name="question" id="question" required/>
	                    </div>
	                    <div class="form-group">
	                       <label for="exampleInputEmail1">Select Image</label>
                           <div class="custom-file">
                               <input type="file" name="image" class="custom-file-input" id="customFile">
                               <img id="preview" class="w-50 img-fluid" style="width:150px">
                           </div>
	                    </div>
	                    <button type="submit" name="submit_questions" class="btn btn-success">Save Questions</button>
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
               <legend>List Questions</legend>
               	<table id="example" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                     <thead>
                        <tr>
                           <th>Question</th>
                           <th>Image</th>
                           <th>Views Answers</th>
                           <th>Edit</th>
                           <th>Delete</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $sqlp = mysqli_query($conexion, "SELECT q.que_code, q.que_description,q.que_image, p.pro_code, p.pro_name, p.pro_subject, p.pro_status
                                          FROM questions_projects  q, projects p WHERE  q.pro_code=p.pro_code AND p.pro_code='" . $proget . "'");
                        while ($row = mysqli_fetch_array($sqlp)) {
                           echo '<tr>';
                           echo '<td>' . $row['que_description'] . '</td>';
                           echo '<td><img class=" icon img-fluid img-thumbnail" src="../images/' . $row['que_image'] . '" width="40"></td>';
                           echo '<td><a href="answers_questions.php?question='.$row['que_code'].'"><img src="../images/Answer_38x38px.png" class="img-thumbnail" width="60"></a></td>';
                           echo '<td><a href="#modaleditquestions'.$row['que_code'].'" data-toggle="modal"><center><img src="../images/editar.png" class="img-thumbnail" width="50"></center></a></td>';
                           echo '<td><a href="../controllers/controller.projects.php?deletequestions=' . $row['que_code'] . '"><img src="../images/eliminar.png" class="img-thumbnail" width="50"></a></td>';
                           
                           include '../forms/edit_questions.php';
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