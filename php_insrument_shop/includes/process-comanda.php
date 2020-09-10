<?php 
    require_once('database_handler.inc.php'); 
    require_once('classes/gestiune/GestiuneTranzactii.php');
    require_once('classes/gestiune/GestiuneProduse.php');

    // procesare date livrare
    $numeClient = $_POST['numeClient-livrare'];
    $prenumeClient = $_POST['prenumeClient-livrare'];
    $emailClient = $_POST['emailClient-livrare'];
    $oras = $_POST['orasClient-livrare'];
    $adresa = $_POST['adresaClient-livrare'];
    $codPostal = $_POST['codPostalClient-livrare'];
    $mesaj = $_POST['mesaj-livrare'];

    // TO DO: filtrare date si validare! (si aici si pe pagina cu formularul)
    $gt = new GestiuneTranzactii();
    $gp = new GestiuneProduse();
    
    // insert shipping info into the table and save the entry ID for the transaction table
    $dateLivrareLastId = $gt->addDateLivrare($numeClient, $prenumeClient, $emailClient, $oras, $adresa, $codPostal, $mesaj);

    // keeo the product list in a json for later use, if needed
    $listaProduseFinal = json_encode($_SESSION['array-prod-final']);

    // insert final transaction data to the database
    $gt->addTranzactie(date('Y-m-d'), $_SESSION['total-order-price'], $listaProduseFinal, $dateLivrareLastId);

    // scadere stoc produs dupa procesarea comenzii 
    foreach($_SESSION['array-prod-final'] as $arrayProd) {
        $gp->decreaseStock($arrayProd['id-produs-final'], $arrayProd['nr-bucati-produs']);
    }

    unset($_SESSION['cart']);
    unset($_SESSION['array-prod-final']);
    header("Location: ../final.php");