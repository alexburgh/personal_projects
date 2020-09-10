<?php 
    require_once(__DIR__ . '/../../database_handler.inc.php');
    session_start();

    class GestiuneTranzactii {
        // method to insert the new transaction in the database (requires calling addDateLivrare() first)
        function addTranzactie($data, $suma, $listaProd, $idLivrare) {
            $sql = "INSERT INTO TRANZACTIE(DATA, SUMA, LISTA_PROD, ID_LIVRARE)
                    VALUES(:data, :suma, :lista_prod, :id_livrare);";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':suma', $suma);
            $stmt->bindParam(':lista_prod', $listaProd);
            $stmt->bindParam(':id_livrare', $idLivrare);

            $stmt->execute();
        }

        // method to add client shipping info to the database
        function addDateLivrare($numeClient, $prenumeClient, $email, $oras, $adresa, $codPostal, $mesaj) {
            $sql = "INSERT INTO DATE_LIVRARE(NUME, PRENUME, EMAIL, ORAS, ADRESA, COD_POSTAL, MESAJ)
                    VALUES(:nume, :prenume, :email, :oras, :adresa, :cod_postal, :mesaj);";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':nume', $numeClient);
            $stmt->bindParam(':prenume', $prenumeClient);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':oras', $oras);
            $stmt->bindParam(':adresa', $adresa);
            $stmt->bindParam(':cod_postal', $codPostal);
            $stmt->bindParam(':mesaj', $mesaj);

            $stmt->execute();

            $lastId = $GLOBALS['conn']->lastInsertId(); // get the inserted shipping row ID for use in the addTranzactie() method, as a FK for the 'tranzactie' table
            return $lastId;
        }
    }