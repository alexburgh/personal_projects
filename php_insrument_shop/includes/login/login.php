<?php

    session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../customCSS/style.css" rel="stylesheet" type="text/css"/>
    <title>Cautare</title>
</head>
<body>
    <div class="container-login main-container text-center">
        <div class="form-container-login col-md-2">
            <form class="form-login" method="post" action="processLogin.php">
                <?php 
                    if(isset($_SESSION['error_message'])) {
                        echo "<p class='login-error_message'>" . $_SESSION['error_message'] . "</p>";
                        unset($_SESSION['error_message']);
                    }
                ?>
                <div class="form-group">
                    <input type="text" class="form-control input-1" name="username" placeholder="Nume utillizator">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control input-1" name="password" placeholder="Parola">
                </div>
                <div class="form-group">
                    <input type="submit" class="input-1 btn btn-success" name="trimite" value="Login">
                </div>
            </form>
        </div>

        <div>
            <p>Nu aveti cont? <a href="register.php">Inregistrati-va</a></p>
        </div>
    </div>
</body>
</html>
