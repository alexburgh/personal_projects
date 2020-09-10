<?php

    include_once("../database_handler.inc.php");

    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT nume, parola FROM utilizator WHERE nume = :username AND parola = :password";
    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    $stmt->execute();

    $utilizatorAutentificat = false;

    while($row = $stmt->fetch()) {
        $utilizatorAutentificat = true;
    }

    if($utilizatorAutentificat == true) {

        $sql2 = "SELECT id as cod_utilizator FROM utilizator WHERE nume = :username AND parola = :password";
        $stmt2 = $GLOBALS['conn']->prepare($sql2);
        $stmt2->bindParam(':username', $username);
        $stmt2->bindParam(':password', $password);

        $stmt2->execute();
        while($row = $stmt2->fetch()) {
            $_SESSION['cod-utilizator-autentificat'] = $row['cod_utilizator'];
        }

        $_SESSION['username'] = $username;
        header("Location:../../index.php");
    } else {
        $_SESSION['error_message'] = "Utilizator sau parola gresita!";
        header("Location:login.php");
    }

