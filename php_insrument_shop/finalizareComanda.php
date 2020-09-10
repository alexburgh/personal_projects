<?php 
    require_once('includes/database_handler.inc.php');
    require_once('includes/classes/modele/Produs.php');
    require_once('includes/classes/gestiune/GestiuneProduse.php');
    include_once('includes/testing-utilities.php');

    session_start();

    // create array with the ids of all products in cart
    $prodIdArray = array_column($_SESSION['cart'], 'idProdusKey');
    
    // create array with the quantities of all products in cart
    $arrayCantProd = array();
    foreach($prodIdArray as $prodId) {
        $nrBucatiProd = $_POST["nr-bucati-produs-{$prodId}"];

        $arrayCantProd[] = $nrBucatiProd;
    }

    // create array with complete product-related order details
    $count = count($prodIdArray);
    for($i = 0; $i < $count; $i++) {
        $arrayProdFinal[] = array(
            "id-produs-final" => $prodIdArray[$i],
            "denumire-produs-final" => $_SESSION['denumire-produse'][$i],
            "nr-bucati-produs" => $arrayCantProd[$i],
            "pret-final-produs" => $_SESSION['pret-produse'][$i]
        );
    }

    $_SESSION['array-prod-final'] = $arrayProdFinal;

    function calculateFinalPrice($array) {
        $sum = 0;
        foreach($array as $produs) {
            $sum = $sum + $produs['nr-bucati-produs'] * $produs['pret-final-produs'];
        }

        return $sum;
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="customCSS/style.css" rel="stylesheet" type="text/css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Finalizare comanda</title>
</head>
<body> 
    <div class="container mainContent">
        <div class="text-center">
            <header class="mainHeader">Finalizare comanda</header>

            <div class="products-display">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>ID Produs</th>
                            <th>Denumire</th>
                            <th>Numar bucati</th>
                            <th>Pret per bucata</th>
                            <th>Pret total</th>
                        </tr>
                    </thead>

                    <tbody> 
                        <?php foreach($arrayProdFinal as $prodFinal): ?>
                        <tr>
                            <td><?= $prodFinal['id-produs-final'] ?></td>
                            <td><?= $prodFinal['denumire-produs-final'] ?></td>
                            <td><?= $prodFinal['nr-bucati-produs'] ?></td>
                            <td><?= $prodFinal['pret-final-produs'] ?></td>
                            <td><?= $prodFinal['nr-bucati-produs'] * $prodFinal['pret-final-produs'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- calculate the total price of all products -->
                <?php $_SESSION['total-order-price'] = calculateFinalPrice($arrayProdFinal); ?> 

                <!-- display total price of products in cart -->
                <div class="col-md-2 float-right text-left pret-total-container">
                    <p class="font-weight-bold">Pret total: <?= $_SESSION['total-order-price'] ?></p> 
                    <div class="pret-total-produse-field-container">
                        <p id="pret-total-produse" class="pret-total-produse-field"></p>
                    </div>
                </div>
            </div>

            <div class="container float-center formContainer col-sm-10">
                <h5 class="final-form-title">Date Livrare</h5>
                <form id="formLivrare" action="includes/process-comanda.php" method="post">
                    <div class="form-group">
                        <label for="numeClient-livrare">Nume<span class="required-star">*</span></label>
                        <input class="form-control center-form-input" type="text" name="numeClient-livrare" required/>
                    </div>
                    <div class="form-group">
                        <label for="prenumenumeClient-livrare">Prenume<span class="required-star">*</span></label>
                        <input class="form-control center-form-input" type="text" name="prenumeClient-livrare" required />
                    </div>
                    <div class="form-group">
                        <label for="emailClient-livrare">Adresa de email<span class="required-star">*</span></label>
                        <input class="form-control center-form-input" type="email" name="emailClient-livrare" required>
                    </div>
                    <div class="form-group">
                        <label for="orasClient-livrare">Oras<span class="required-star">*</span></label>
                        <input class="form-control center-form-input" type="text" name="orasClient-livrare" required>
                    </div>
                    <div class="form-group">
                        <label for="orasClient-livrare">Adresa client<span class="required-star">*</span></label>
                        <input class="form-control center-form-input" type="text" name="adresaClient-livrare" required>
                    </div>
                    <div class="form-group">
                        <label for="orasClient-livrare">Cod postal<span class="required-star">*</span></label>
                        <input class="form-control center-form-input" type="text" name="codPostalClient-livrare" required>
                    </div>
                    <div class="form-group">
                        <label for="orasClient-livrare">Detalii comanda</label>
                        <textarea class="form-control center-form-input" name="mesaj-livrare" onfocus="this.innerHTML=''">Lasati-ne un mesaj...</textarea>
                    </div>
                    <input type="submit" class="btn btn-success buton-plasare-comanda" value="Plasare comanda">
                </form>
            </div>
        </div>
    </div>

</body>
</html>