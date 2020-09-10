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
            <form class="form-login" method="post" action="processRegister.php">
                <?php 
                    if(isset($_SESSION['error_message'])) {
                        echo "<p class='login-error_message'>" . $_SESSION['error_message'] . "</p>";
                        unset($_SESSION['error_message']);
                    }
                ?>
                <div class="form-group">
                    <input type="text" class="form-control input-1" name="username" placeholder="Nume utilizator" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control input-1" name="password" placeholder="Parola" required>
                </div>
                <div class="form-group">
                <?php 
                    if(filter_input(INPUT_GET, 'message') == 'wemail') 
                        require_once('email-error.php');
                ?>

                    <input type="email" class="form-control input-1" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success input-1" name="trimite" value="Inregistrare">
                </div>
            </form>
        </div>

        <div>
            <p>Aveti deja cont? <a href="login.php">Inapoi la pagina de logare</a></p>
        </div>
    </div>
</body>
</html>