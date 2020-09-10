<?php

    include_once("../database_handler.inc.php");

    session_start();

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    /* TO DO: add messages when fiels are empty with JS */

    if(isset($_POST["trimite"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location:register.php?message=wemail");
        }
        // check if entered username already exists in the database 
        $sql = "SELECT COUNT(nume) AS nume_utilizator FROM utilizator WHERE nume = :nume"; 
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nume', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row['nume_utilizator'] > 0) {
            echo "<script language='javascript'>
            alert('Numele de utilizator exista deja!');
            </script>";
            echo "<script> window.location = 'register.php' </script>";
            // header("Location:register.php");
        } else {


            // if the username is unique, proceed to insert the data into the database

            $sql = "INSERT INTO utilizator(nume, parola, email) VALUES(:nume, :parola, :email);";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nume', $username);
            $stmt->bindParam(':parola', $password);
            $stmt->bindParam(':email', $email);

            $inserted = $stmt->execute();

            if($inserted):
            ?>
                <div class="registered-container" style="margin: auto; margin-top: 15%; text-align: center; ">
                    <h3 style="font-family: sans-serif;">Va multumim pt. ca v-ati inregistrat!</h3>
                    <br>
                    <a href='login.php' style="border: 1px solid #84bd00; background: #84bd00; border-radius: 5px; padding: 10px; text-decoration: none; color: white;">
                        Inapoi la pagina de logare.
                    </a>
                </div>
                        
            <?php
                endif;
        }

    } else {
        $_SESSION['error_message'] = "Toate campurile sunt obligatorii!";
        header("Location:register.php"); // daca unul dintre campuri este gol, reintoarcere la pagina de register
    }
