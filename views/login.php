<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="../css/login.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/varios.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
    <div id="formContent">
        <br><br>
        <div class="fadeIn first">
            <img src="../images/LogoKomunIKON.png" id="icon" alt="User Icon"/>
        </div>
        <br>
        <form class="form-inline" action="../controllers/controller.login.php" method="POST">
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputPassword2" class="sr-only">Password</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" onblur="validation_rol()">            
        </div>
        <div class="form-group mx-sm-3 mb-2">
        <button type="button" class="btn btn-primary mb-2">Search</button>
        </div>
        <div id=resultadorol></div>
        </form>
        <div id="formFooter">
            <a class="underlineHover" href="index.php">Register</a>
        </div>

    </div>
</div>