<?php
	require_once('includes/classes/gestiune/GestiuneCategorii.php');
	require_once('includes/database_handler.inc.php');
	require_once('includes/classes/gestiune/GestiuneProduse.php');
	// include_once('includes/testing-utilities.php');

	session_start();
	
	// if the user is not logged in
	if(!isset($_SESSION['username'])) {
		header("Location:includes/login/login.php");
	} 

	if(isset($_POST["add-to-cart"])) {
		if(isset($_SESSION["cart"])) {
			$productId_Array = array_column($_SESSION["cart"], "idProdusKey"); // retrieve all product ids from the idProdusKey column of the sub-arrays
			
			if(in_array($_POST["id-produs"], $productId_Array)) { // if the product is already in the array
				echo "<script>alert('Produsul a fost deja adaugat in cos!')</script>";
				echo "<script>window.location = 'index.php'</script>";
			} else {
				$count = count($_SESSION["cart"]); 
				$productId_Array = array('idProdusKey' => $_POST['id-produs']); // create a sub-array with product id
				$_SESSION["cart"][$count] = $productId_Array; // add the sub-array to the cart array
			}

		} else {
			$productIdArray = array('idProdusKey' => $_POST['id-produs']);
			$_SESSION["cart"][0] = $productIdArray;
		}
	}

	if(isset($_POST['insert-product'])) {
		if(!empty($_POST['product-insert-name']) && !empty($_POST['product-insert-price']) && !empty($_POST['product-insert-category']) && !empty($_POST['product-insert-sku']) && isset($_POST['product-insert-stock'])) {
			$numeProdusInserat = $_POST['product-insert-name'];
			$pretProdusInserat = $_POST['product-insert-price'];
			$categorieProdusInserat = $_POST['product-insert-category'];
			$skuProdusInserat = $_POST['product-insert-sku'];
			$stocProdusInserat = $_POST['product-insert-stock'];

			$gp = new GestiuneProduse();
			$gp->insertProduct($numeProdusInserat, $pretProdusInserat, $categorieProdusInserat, $skuProdusInserat, $stocProdusInserat);
			unset($gp);
		}
	}

	// product update
	if(isset($_POST['update-product'])) {
		if(!empty($_POST['product-update-name']) && !empty($_POST['product-update-price']) && !empty($_POST['product-update-category']) && !empty($_POST['product-update-sku']) && isset($_POST['product-update-stock'])) {
			$updatedProductId = $_POST['updated-product-id'];

			$gp = new GestiuneProduse();
			$gp->updateProduct($updatedProductId, $_POST['product-update-name'], $_POST['product-update-price'], $_POST['product-update-category'], $_POST['product-update-sku'], $_POST['product-update-stock']);
			unset($gp);
			echo "<script> window.alert('Produsul a fost actualizat!');</script>";
		}
	}


	// product deletion
	if(isset($_SESSION['cod-utilizator-autentificat'])) {
		if($_SESSION['cod-utilizator-autentificat'] == 1) {
			if(filter_input(INPUT_GET, 'action') == 'delete') {
				$gp = new GestiuneProduse();
				$gp->deleteProduct(filter_input(INPUT_GET, 'id'));
				unset($gp); 
				echo "<script> window.alert('Produsul a fost sters!');</script>";
			}
		}
	}

	
	// if the logout button was clicked and confirmed, destroy session and redirect to login page
	if(filter_input(INPUT_GET, 'action') == 'logout') {
		session_unset(); 
		session_destroy();
		header("Location:includes/login/login.php");
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="customCSS/style.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="scripts/insert-product-reveal.js"></script>
	<title>Cautare</title>
</head>
<body>
<div class="container mainContent">
	<div class="text-center">
		<header class="mainHeader">
			<?php require_once('header.php'); ?>
		</header>

		<!-- admin panel -->
		<?php
			if(isset($_SESSION['cod-utilizator-autentificat'])):
				if($_SESSION['cod-utilizator-autentificat'] == 1):
		?>
		
		<div class="container">
			<div class="container admin-panel col-md-6">
				<h5>Admin panel</h5>
				<!-- sectiune inserare produs nou -->
				<button type="button" class="btn btn-success insert-product-reveal" onclick="showInsertSection()">Inserare produs</button>
				<div id="insert-product-adminsect" class="insert-product-container text-center" style="display: none;"> <!-- inline style needed for button script to run properly -->
					<h5>Inserare Produs</h5>
					<form class="insert-product-form" method="post" action="index.php">
						<div class="form-group">
							<?php 
								if(isset($_POST['insert-product'])) {
									if(empty($_POST['product-insert-name'])) {
										require_once('form-error.php');
									}
								}
							?>
							<input type="text" name="product-insert-name" class="form-control" placeholder="Denumire produs...">
						</div>
						<div class="form-group">
							<?php 
								if(isset($_POST['insert-product'])) {
									if(empty($_POST['product-insert-price'])) {
										require_once('form-error.php');
									}
								}
							?>
							<input type="number" name="product-insert-price" class="form-control" placeholder="Pret...">
						</div>
						<div class="form-group">
							<?php 
								if(isset($_POST['insert-product'])) {
									if(empty($_POST['product-insert-category'])) {
										require_once('form-error.php');
									}
								}
							?>
							<select class="form-control" name="product-insert-category" id="categorie-produs-insert-dropdown">
							<!-- generate list items in a loop from the database category table -->
								<option value="" selected disabled hidden>--Alegeti o categorie din lista--</option>
								<?php 
									$gc = new GestiuneCategorii();
									$categorii = $gc->getCategorii();

									foreach($categorii as $categorie):
								?>
									<option value="<?= $categorie->getIdCategorie() ?>"><?= $categorie->getDenCategorie() ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<input type="text" name="product-insert-sku" class="form-control" placeholder="SKU...">
						</div>
						<div class="form-group">
							<?php 
								if(isset($_POST['insert-product'])) {
									if(empty($_POST['product-insert-stock'])) {
										require_once('form-error.php');
									}
								}
							?>
							<input type="number" name="product-insert-stock" class="form-control" placeholder="Stoc...">
						</div>
						<div class="form-group">
							<input type="submit" name="insert-product" class="btn btn-outline-success btn-lg  btn-block insert-product-button" value="Inserare">
						</div>
					</form>
				</div>

				<div class="export-buttons text-center">
					<a href="scripts/export-table.php?action=export&table=produs" class="btn btn-success">Export Produse</a>
					<a href="scripts/export-table.php?action=export&table=tranzactie" class="btn btn-success">Export Tranzactii</a>
				</div>
			</div>
		</div>

		<?php 
			endif;
			endif; 
		?>

		<!-- sort products by category -->
		<form id="formCategorieProdus" action="rezultateProdDupaCateg.php" method="post">
			<label for="categorie-produs-dropdown">Sortare dupa categorie:</label>
			<select name="select-categorie-produs" id="categorie-produs-dropdown">
			<!-- generate list items in a loop from the database category table -->
				<option value="">--Alegeti o categorie din lista--</option>

			<?php 
				$gc = new GestiuneCategorii();
				$categorii = $gc->getCategorii();

				foreach($categorii as $categorie):
			?>
				<option value="<?= $categorie->getIdCategorie() ?>"><?= $categorie->getDenCategorie() ?></option>
			<?php endforeach; ?>

			</select>
			<input type="submit" value="Sorteaza" class="homeInputButton">
		</form>
		
		<!-- Cautare produs -->
		<form id="formCautareProdus" action="rezultateProduse.php" method="post">
			Cautare produs: <input type="text" name="nume-produs">
			<input type="submit" value="Cauta" class="homeInputButton">
		</form>
		
		<!-- Afisare toate produsele -->
		<table class="table table-bordered table-striped text-center">
			<thead>
				<tr>
					<th>ID Prod</th>
					<th>Denumire</th>
					<th>Categorie</th>
					<th>Pret</th>
					<th>SKU</th>
					<th>Stoc</th>
					<th></th>
					
				</tr>
            </thead>
            <tbody>	
				<tr>

				<?php 
					$gp = new GestiuneProduse();
					$gc = new GestiuneCategorii();
					$produse = $gp->getProduseMagazin();

						foreach($produse as $key => $produs):
							$numeCategorie = $gc->getNumeCategorie($produs->getIdCategorie());
							$idProdus = $produs->getIdProdus();
					?>

						<tr>
							<td><?= $produs->getIdProdus() ?></td>
							<td><?= $produs->getDenumireProdus() ?></td>
							<td><?= $numeCategorie ?></td>
							<td><?= $produs->getPret() ?></td>
							<td><?= $produs->getSku() ?></td>
							<td><?= $produs->getStoc() ?></td>
							<td>
								<form id="cumparareProdus" action="index.php" method="post"> 
									<input type="hidden" id="id-produs" name="id-produs" value="<?= $idProdus ?>"> 
									<input type='submit' name='add-to-cart' value='Adauga in cos' class='btn btn-primary add-to-cart-button'> 
								</form>
							</td>
							<?php
								if(isset($_SESSION['cod-utilizator-autentificat'])):
									if($_SESSION['cod-utilizator-autentificat'] == 1):
							?>

							<td>
								<form id="actualizareProdus" action="updateProduct.php" method="post">
									<input type="hidden" id="id-produs-editat" name="id-produs-editat" value="<?= $idProdus ?>">
									<input type="submit" name="edit-product" class="btn btn-primary" value="Actualizare">
								</form>
							</td>
							<!-- <td><a class="btn btn-primary" onclick="scripts/reveal-updater.js">Actualizare</a></td> -->
							<td><a href="index.php?action=delete&id=<?= $produs->getIdProdus() ?>" class="btn btn-danger">Stergere</a></td>

							<?php 
								endif; 
								endif;
							?>
						</tr>

				<?php 
					endforeach;
				?>

                </tr>
            </tbody>
        </table>
	</div>
</div>

<script src="scripts/logout-confirm.js"></script>
</body>
</html>        