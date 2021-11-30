<?php
require_once '../controllers/connection.php';
session_start();
if (isset($_SESSION['email'])) {
	?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>KomunIKON</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">        
        <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../public/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../public/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        
    </head>
<body class="hold-transition skin-green  sidebar-mini e login-page">
<div class="wrapper">
    <header class="main-header">
        <a href="../vistas/inicio.php" class="logo">
            <span class="logo-mini"><b>KMK</b></span>
            <span class="logo-lg"><b>KomunIKON</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="glyphicon glyphicon-arrow-left" data-toggle="push-menu" role="button">
                Hide
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Welcome: <?php echo $_SESSION['email']; ?>
                            <?php //echo $resuses['age_descri']
	?>
                            <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                        </a>
                    </li>
                    <li class="dropdown notifications-menu">
                        <a href="logout.php">
                            <i class="fa fa-times"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MENU</li>
                <li class="">
                    <a href="projects.php">
                        <i class="fa fa-pie-chart" aria-hidden="true"></i> <span>Projects</span>
                    </a>
                </li>
            </ul>
        </section>
    </aside>
    <script src="../public/bower_components/jquery/dist/jquery.min.js"></script>
    
    <script src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../public/dist/js/adminlte.min.js"></script>
    <script src="../public/dist/js/demo.js"></script>
<?php
} else {
	header('Location: login.php');
}
?>