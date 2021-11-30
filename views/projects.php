<?php
require_once '../controllers/connection.php';
require_once 'header.php';
//QUERY USER
$user = mysqli_query($conexion, "SELECT * FROM iconometer_users WHERE usr_email='" . $_SESSION['email'] . "'");
$rowuser = mysqli_fetch_array($user);

if (in_array($rowuser['rol_code'], array('1'), true)) {
	$sql = mysqli_query($conexion, "SELECT * FROM projects");
} elseif (in_array($rowuser['rol_code'], array('2'), true)) {
	$sql = mysqli_query($conexion, "SELECT q.que_code, q.que_description, p.pro_code, p.pro_name, p.pro_subject, p.pro_status
       FROM questions_projects  q, projects p WHERE  q.pro_code=p.pro_code AND pro_status=1 GROUP BY p.pro_code;");
} else {
}
//INSERT TABLE TMP

?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<div class="content-wrapper">
   <section class="content">
      <?php
      if (in_array($rowuser['rol_code'], array('1'), true)) {
      ?>
      <div class="box">
         <div class="box-body">
            <div class="container-fluid">
               <div class="row">                              
                  <div class="col-md-12">
                     <form  role="form" action="../controllers/controller.projects.php" method="POST" class="form-inline">
                     <fieldset>
                        <legend>Create Project:</legend>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Project Name</label>
                              <input type="text" class="form-control" name="project" id="project" />
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Project Subject</label>
                              <input type="text" class="form-control" name="subject" id="subject" />
                           </div>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Status Project</label>
                              <select class="form-control" name="status">
                                 <option disabled="" selected="">Select..</option>
                                 <option value="1">Active</option>
                                 <option value="0">Inactive</option>
                              </select>
                           </div>
                           <button type="submit" name="submit_project" class="btn btn-success">Save Project</button>
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
               <legend>List Project:</legend>
                  <table id="example" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                     <thead>
                        <tr>
                           <th>Project</th>
                           <th>Theme</th>
                           <?php if (in_array($rowuser['rol_code'], array('1'), true)) {?>
                           <th>Created</th>
                           <th>Questions</th>                        
                           <th>General Report</th>
                           <th>Individual Report</th>
                           <th>Report Final</th>
                           <th>Status</th>
                           <th>Edit</th>
                           <th>Delete</th>
                           <?php }?>
                           <?php if (in_array($rowuser['rol_code'], array('2'), true)) {?>
                           <th>Start</th>
                           <?php }?>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($sql)) {
                           echo '<tr>';
                           echo '<td>' . $row['pro_name'] . '</td>';
                           echo '<td>' . $row['pro_subject'] . '</td>';
                           if (in_array($rowuser['rol_code'], array('1'), true)) {
                              echo '<td>' . $row['pro_created'] . '</td>';
                              echo '<td><a href="create_questions.php?project=' . $row['pro_code'] . '"><img src="../images/Quastion_38x38px.png" class="img-thumbnail" width="60"></a></td>';
                              
                              echo '<td><a href="graph.php?project=' . $row['pro_code'] . '" target="_BLANK"><img src="../images/report.png" class="img-thumbnail" width="50"></a></td>';
                              echo '<td><a href="graph_individual.php?project=' . $row['pro_code'] . '" target="_BLANK"><img src="../images/report.png" class="img-thumbnail" width="50"></a></td>';
                              echo '<td><a href="graph_final.php?project=' . $row['pro_code'] . '" target="_BLANK"><img src="../images/report.png" class="img-thumbnail" width="50"></a></td>';
                              if ($row['pro_status'] == 1) {
                                 echo '<td><a href="../controllers/controller.projects.php?statusa=' . $row['pro_status'] . '&pro_code=' . $row['pro_code'] . '"><span class="btn btn-success">Active</span></a></td>';
                              } else {
                                 echo '<td><a href="../controllers/controller.projects.php?statusi=' . $row['pro_status'] . '&pro_code=' . $row['pro_code'] . '"><span class="btn btn-danger">Inactive</span></a></td>';
                              }
                              echo '<td><a href="#modaleditproject'.$row['pro_code'].'" data-toggle="modal"><center><img src="../images/editar.png" class="img-thumbnail" width="50"></center></a></td>';
                              echo '<td><a href="../controllers/controller.projects.php?delete=' . $row['pro_code'] . '"><img src="../images/eliminar.png" class="img-thumbnail" width="50"></a></td>';
                              include '../forms/edit_project.php';
                              echo '</tr>';
                           }
                           if (in_array($rowuser['rol_code'], array('2'), true)) {
                              $project = mysqli_query($conexion, "SELECT q.que_code, q.que_description, p.pro_code, p.pro_name, p.pro_subject, p.pro_status
                                                   FROM questions_projects  q, projects p WHERE q.pro_code = p.pro_code AND p.pro_status = 1 GROUP BY p.pro_status");
                              $rowpro = mysqli_fetch_array($project);
                              echo '<td><a href="start_projects.php><img src="../images/check.png" class="img-thumbnail" width="40"></a></td>';
                              
                           }
                        }
                        ?>
                     </tbody>
                  </table>
               </fieldset>
               </div>
            </div>
         </div>
      </div>
      <?php
      }else{
      ?>
      <div class="box">
         <div class="box-body">
            <div class="container-fluid">
               <div class="row">
               <fieldset>
               <legend>List Project:</legend>
                  <table id="example" class="table table-bordered table-striped dt-responsive tablas" width="100%">
                     <thead>
                        <tr>
                           <th>Project</th>
                           <th>Theme</th>
                           <?php if (in_array($rowuser['rol_code'], array('1'), true)) {?>
                           <th>Created</th>
                           <th>Questions</th>                        
                           <th>General Report</th>
                           <th>Individual Report</th>
                           <th>Status</th>
                           <th>Edit</th>
                           <th>Delete</th>
                           <?php }?>
                           <?php if (in_array($rowuser['rol_code'], array('2'), true)) {?>
                           <th>Start</th>
                           <?php }?>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($sql)) {
                           echo '<tr>';
                           echo '<td>' . $row['pro_name'] . '</td>';
                           echo '<td>' . $row['pro_subject'] . '</td>';
                           if (in_array($rowuser['rol_code'], array('1'), true)) {
                              echo '<td>' . $row['pro_created'] . '</td>';
                              echo '<td><a href="create_questions.php?project=' . $row['pro_code'] . '"><img src="../images/KomunIKON_Question.png" class="img-thumbnail" width="40"></a></td>';
                              
                              echo '<td><a href="graph.php?project=' . $row['pro_code'] . '" target="_BLANK"><img src="../images/report.png" class="img-thumbnail" width="40"></a></td>';
                              echo '<td><a href="graph_individual.php?project=' . $row['pro_code'] . '" target="_BLANK"><img src="../images/report.png" class="img-thumbnail" width="40"></a></td>';
                              if ($row['pro_status'] == 1) {
                                 echo '<td><a href="../controllers/controller.projects.php?statusa=' . $row['pro_status'] . '&pro_code=' . $row['pro_code'] . '"><span class="btn btn-success">Active</span></a></td>';
                              } else {
                                 echo '<td><a href="../controllers/controller.projects.php?statusi=' . $row['pro_status'] . '&pro_code=' . $row['pro_code'] . '"><span class="btn btn-danger">Inactive</span></a></td>';
                              }
                              echo '<td><a href="../controllers/controller.projects.php?delete=' . $row['pro_code'] . '"><img src="../images/editar.png" class="img-thumbnail" width="40"></a></td>';
                              echo '<td><a href="../controllers/controller.projects.php?delete=' . $row['pro_code'] . '"><img src="../images/eliminar.png" class="img-thumbnail" width="40"></a></td>';
                              echo '</tr>';
                           }
                           if (in_array($rowuser['rol_code'], array('2'), true)) {
                              /*$project = mysqli_query($conexion, "SELECT q.que_code, q.que_description, p.pro_code, p.pro_name, p.pro_subject, p.pro_status
                                                   FROM questions_projects  q, projects p WHERE q.pro_code = p.pro_code AND p.pro_status = 1 GROUP BY p.pro_status");
                              $rowpro = mysqli_fetch_array($project);*/
                              $sqlprou=mysqli_query($conexion,"SELECT * FROM projects_users WHERE usr_code ='".$rowuser['usr_code']."' AND pro_code ='".$row['pro_code']."'");
                              //var_dump('<td>'.$salprou.'</td>');
                              if(mysqli_num_rows($sqlprou)){
                                 echo '<td><div class="p-3 mb-2 bg-primary text-white">COMPLETED</div></td>';
                              }else{
                                 echo '<td><a href="start_projects.php?quest='.$row['que_code'].'&email='.$rowuser['usr_email'].'&project='.$row['pro_code'].'" ><img src="../images/check.png" class="img-thumbnail" width="40"></a></td>';                                                            
                              }
                              /*while($rowpru=mysqli_fetch_array($sqlprou)){
                                 //var_dump('<td>'.$rowpru['pro_code'].'</td>');
                                 if(($rowpru['pru_status']=='COMPLETED') && ($rowpru['pro_code']=$row['pro_code'])){
                                    echo '<td>nada</td>';
                                 }else{
                                    echo '<td>je sais pas</td>';
                                 }                                 
                              }*/
                              //
                              //echo '<td><a href="startprojects.php?quest=' . $row['que_code'] . '&email=' . $rowuser['usr_email'] . '&project=' . $row['pro_code'] . '" target="_BLANK"><img src="../images/check.png" class="img-thumbnail" width="40"></a></td>';
                              //header ('Location: ../views/startprojects.php?quest='.$rowpro['que_code'].'&email='.$email=$_POST['email'].'');
                           }
                        }
                        ?>
                     </tbody>
                  </table>
               </fieldset>
               </div>
            </div>
         </div>
      </div>
      <?php
      }
      ?>
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