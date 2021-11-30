<?php
require_once '../controllers/connection.php';
include 'header.php';
$projects = mysqli_query($conexion, "SELECT * FROM projects");
?>
<!DOCTYPE html>
<html>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/varios.js"></script>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="box">
                        <div class="panel-body">
                            <div class="col-md-6">
                                <!-- general form elements -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Create Project</h3>
                                    </div>
                                    <form role="form" action="../controllers/controller.projects.php" method="POST">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Project Nane</label>
                                                <input type="text" name="project" class="form-control"
                                                       id="exampleInputEmail1" placeholder="Project Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Project Subject</label>
                                                <input type="text" name="subject" class="form-control"
                                                       id="exampleInputEmail1" placeholder="Project Subject">
                                            </div>
                                            <div class="form-group">
                                                <label>Status Project</label>
                                                <select class="form-control" name="status">
                                                    <option disabled="" selected="">Select..</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                    >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success" name="submit_project">
                                                Save a project
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Questions</h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" action="../controllers/controller.projects.php" method="POST"
                                              enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label>Select Project</label>
                                                    <select class="form-control" name="project">
                                                        <option disabled="" selected="">Select..</option>
                                                        <?php
                                                        while ($rowprojects = mysqli_fetch_array($projects)) {
                                                            echo '<option value="'.$rowprojects['pro_code'].'">'.$rowprojects['pro_subject'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Question Name</label>
                                                    <input type="text" name="question" class="form-control"
                                                           id="exampleInputEmail1" placeholder="Project Name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Select Image</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="image" class="custom-file-input"
                                                               id="customFile">
                                                        <img id="preview" class="w-50 img-fluid">
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-success"
                                                                name="submit_questions">Save a question
                                                        </button>
                                                    </div>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="box">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Questions</h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" action="../controllers/controller.projects.php" method="POST">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Project</label>
                                                    <select class="form-control" name="project" id="project"
                                                            onclick="questions_projects()">
                                                        <option disabled="" selected="">Select Project..</option>
                                                        <?php
                                                        $querypro = mysqli_query($conexion, "SELECT * FROM projects");
                                                        while ($rowquerypro = mysqli_fetch_array($querypro)) {
                                                            echo '<option value='.$rowquerypro['pro_code'].'>'.$rowquerypro['pro_subject'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div id="result"></div>
                                                <div id="resultans"></div>
                                                <div id="resultadd"></div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div>
        </section>
    </div>
</div>
<!-- ./wrapper -->
<script>
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
</body>
</html>
