<?php
require_once '../controllers/connection.php';
$usr   = mysqli_query($conexion, "SELECT * FROM iconometer_users WHERE usr_email='".$_POST['email']."'");
$rowus = mysqli_fetch_array($usr);
echo '<input type="hidden" name="rol" id="rol" value="'.$rowus['rol_code'].'">';

if ($rowus['rol_code'] == 1) {
    echo '<input type="password" id="password" class="fadeIn third" name="password" placeholder="password">';
    echo '<div class="form-group mx-sm-3 mb-5">';
    echo '<input type="submit" class="fadeIn fourth" name="submit" id="submit" value="Log In">';
    echo '</div>';
} else if($rowus['rol_code'] == 2) {    
    echo '<input type="submit" class="fadeIn fourth" name="submit" id="submit" value="Log In">';
}else {

}


?>