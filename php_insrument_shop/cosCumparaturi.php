<?php 
	require_once('includes/classes/modele/Produs.php');
	require_once('includes/classes/gestiune/GestiuneProduse.php');
	require_once('includes/database_handler.inc.php');
	include_once('includes/testing-utilities.php');

	session_start(); 

	// function to remove the product from cart based on GET url
	if(filter_input(INPUT_GET, 'action') == 'delete') {
		foreach($_SESSION['cart'] as $key => $value) {
			if($value['idProdusKey'] == filter_input(INPUT_GET, 'id')) {
				unset($_SESSION['cart'][$key]);
			}
		}
	 }

	 if(isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array_values($_SESSION['cart']); // reset session array keys so they match with $product_ids numeric array
		$_SESSION['pret-produse'] = array(); // create array to save the cart product prices
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
	<title>Cautare</title>
</head>
<body onload=updateTotalPrice(createInputArray())> <!-- after the page loads, calculate the total price of all products in the cart -->
    <div class="container mainContent">
        <div class="text-center">
            <header class="mainHeader">Cos de cumparaturi
				<?php $preturiProduse = array(); ?>
			</header>

			<div class="products-display">
			<?php if(isset($_SESSION['cart'])): ?>
				<form id="form-produse-cos" method="post" action="finalizareComanda.php">
					<table class="table table-bordered table-striped text-center">
						<thead>
							<tr>
								<th>ID Produs</th>
								<th>Denumire</th>
								<th>Pret</th>
								<th>Numar bucati</th>
							</tr>
						</thead>

						<tbody>
							<?php
								$gestiuneProduse = new GestiuneProduse();
								$productIdArray = array_column($_SESSION['cart'], 'idProdusKey'); 

								foreach($productIdArray as $idProdusCos):
									$produs = $gestiuneProduse->getProdusDupaId(intval($idProdusCos)); // extragere obiect produs in functie de ID 
									$stocProdus = $produs->getStoc();
									$pretProdus = intval($produs->getPret()); 
							?>

								<tr>
								<td class="id-produs-bd"> <?= $produs->getIdProdus() ?> </td>
								<td> <?= $produs->getDenumireProdus() ?> </td>
								<?php $_SESSION['denumire-produse'][] = $produs->getDenumireProdus(); ?>
								<td id="pret-field-<?= $idProdusCos ?>"> <?= $produs->getPret() ?> </td>
								<?php $_SESSION['pret-produse'][] = $produs->getPret(); ?>
								<td> 
									<input type="number" class="nr-bucati-produs" name="nr-bucati-produs-<?= $idProdusCos ?>" id="nr-bucati-produs-<?= $idProdusCos ?>" min="1" max=<?= $stocProdus ?> value="1" oninput="updateProductPrice(<?= $pretProdus ?>, <?= $idProdusCos ?>); updateTotalPrice(createInputArray());"> <!--when changing the product quantity, recalculate the product*quantity price and total price of products in cart -->
								</td>
								<td>
									<a href="cosCumparaturi.php?action=delete&id=<?= $idProdusCos ?>" class="btn btn-danger">Stergere produs</a>
								</td>
								</tr>

								<input type="hidden" class="pret-total-produs-hidden" name="pret-total-input" value="pret-field-<?= $idProdusCos ?>">
								<input type="hidden" class="nr-bucati-produs-hidden" name="numar-bucati-input" value="nr-bucati-produs-<?= $idProdusCos ?>">
							<?php endforeach; ?>
						</tbody>
					</table>

					<!-- Afisare pret total produse din cos -->
					<div class="col-md-2 float-right text-left pret-total-container">
						<p class="font-weight-bold">Pret total: </p> 
						<div class="pret-total-produse-field-container">
							<p id="pret-total-produse" class="pret-total-produse-field"></p>
						</div>
					</div>

					<!-- Confirmare comanda -->
					<div class="text-center comanda-button-container">
						<input type="submit" name="cart-final" class="btn btn-outline-success btn-lg  btn-block comanda-button" value="Finalizare comanda">
					</div>
				</form>
			<?php else: ?>
				<div class="empty-cart text-center col-md-5">
					<div class="empty-cart-title"><b>Cosul este gol</b></div>
					<div>
						<div class="empty-cart-message">Pentru a adauga in cos produsele dorite,</div>
						<div>te rugam sa te intorci la magazin</div>
						<a href="index.php" class="btn btn-success empty-cart-button">Inapoi la magazin</a>
					</div>
				</div>
			<?php endif; ?>
			</div>
        </div>
	</div>

	<script>
		// function to update product price when changing quantity
		function updateProductPrice(pretBucata, idProdus) {
			let nrBucati = document.getElementById("nr-bucati-produs-" + idProdus).value;
			var pretFinal = nrBucati*pretBucata;
			
			document.getElementById("pret-field-" + idProdus).innerHTML = pretFinal;
			return pretFinal;
		}	

		// function to take all price field IDs from products in cart and put them in a string
		function createInputArray() {
			let inputs = document.getElementsByClassName('pret-total-produs-hidden');
    		let names  = [].map.call(inputs, function(input) {
        		return input.value;
    		}).join('|');
			
			return names;
		}

		// function to calculate the total price of products in cart in real time
		function updateTotalPrice(inputIds) {
			let totalCartPrice = 0;
			inputIdArray = inputIds.split("|"); 
			inputIdArray.forEach(myFunction); 

			function myFunction(item) {
				totalCartPrice = totalCartPrice + Number(document.getElementById(item).innerText);
			}

			document.getElementById("pret-total-produse").innerHTML = totalCartPrice;
		}
	</script>
</body>
</html>        