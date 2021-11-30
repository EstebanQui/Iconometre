<?php
include 'header.php';
$email =$_GET['email'];
$project = $_GET['project'];
?>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form  role="form"  class="form-inline" action="../controllers/controller.commentary.php" method="post">
                                <fieldset>
                                    <legend>Project Name:</legend>
                                    <input type="hidden" name="email" value="<?php echo $email?>">
                                    <input type="hidden" name="project" value="<?php echo $project?>">
                                    <div class="form-group">
                                        <textarea class="form-control" id="commentary" name="commentary" rows="10" cols="130" ></textarea>
                                    </div>
                                    <br><br>
                                    <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Submit Commentary">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
