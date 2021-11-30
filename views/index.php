<?php
require_once "../controllers/controller.lang.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Iconometre</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
<body class="container">
<div class="row">
    <div class="card hearder">
        <h1>Iconomètre KomunIKON</h1>
    </div>
    <div class="card body">
        <p class="blockquote">You have to distribute 100 points among these meanings according to your perceived probability of which is the correct meaning of the icon. <br>
            You can give 100 points to one meaning (if you are sure that this is the intended meaning),
            or 70 to one meaning and 30 to another, or 40, 20, 30, or 21, 33, 3, 21, 12, 9, 1,
            or even 100 points to "I don't know" if you don't perceive any meaning from this icon. <br>
            Each score must be a positive integer and the sum of the seven scores must be 100.

            After distributing the points you must click on "sauver hypothèses", then click on the following number (going to the next icon) and repeat point 6.

            The whole interface is only in French.

            After completing the test, please write in the form below any comments or suggestions to improve the icons, the procedure, the test, the interface or anything else. Thank you!

            The KomunIKON team <a href="www.komunikon.com" target="_blank">www.komunikon.com</a>

            You can find us also on Facebook, Linkedin and Instagram, follow us!</p>
    </div>

    <!-- Formulario para los usuarios del test action="../controllers/controller.users.php"-->
    <div class="card footer">
        <form class="formulaire" name="start"  action="../controllers/controller.users.php" method="post">
            <div class="mb-3">
                <div class="col auto">
                    <label for="name">First Name</label>
                    <input type="text" name="name" placeholder="name" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <div class="col auto">
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" placeholder="surname" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <div class="col auto">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="mail" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <div class="col auto">
                    <label for="speak">Mother Tongue</label>
                    <select name="language" class="form-select">
                        <option selected disabled>Select your language</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($lang)) {
                            echo '<option value="'.$row['lan_code'].'">'.$row['lan_description'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <div class="col auto">
                    <label for="speak">High Languages level</label>
                    <select name="languagehigh[]" class="form-select" multiple="multiple">
                        <option selected disabled>Select your languages</option>
                        <?php
                        while ($row1 = mysqli_fetch_assoc($lang1)) {
                            echo '<option value="'.$row1['lan_description'].'">'.$row1['lan_description'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <div class="col auto">
                    <label for="speak">Intermediate Languages Level</label>
                    <select name="languageint[]" class="form-select" multiple="multiple">
                        <option selected disabled>Select your languages</option>
                        <?php
                        while ($row2 = mysqli_fetch_assoc($lang2)) {
                            echo '<option value="'.$row2['lan_description'].'">'.$row2['lan_description'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <div class="col auto">
                    <label for="speak">Basic Languages Level</label>
                    <select name="languagebasic[]" class="form-select" multiple="multiple">
                        <option selected disabled>Select your languages</option>
                        <?php
                        while ($row3 = mysqli_fetch_assoc($lang3)) {
                            echo '<option value="'.$row3['lan_description'].'">'.$row3['lan_description'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <div class="col auto">
                    <label for="comentary">Your comment</label>
                    <textarea name="comentary" id="1" cols="70" rows="10" class="form-control"></textarea>
                </div>
            </div>
            <input type="submit" value="submit" name="submit">
        </form>
    </div>
    <!--chercher un site qui comprenne mes besoins ou une application ou du code prefet-->
</div>
</body>
</html>