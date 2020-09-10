<?php 
    require_once('includes/classes/modele/Produs.php');
    require_once('includes/classes/gestiune/GestiuneProduse.php');
    require_once('includes/database_handler.inc.php');
    require_once('includes/classes/gestiune/GestiuneCategorii.php');

    session_start();

    if(!isset($_SESSION['username'])) {
		header("Location:includes/login/login.php");
	} 

	if(isset($_POST["add-to-cart"])) {
		if(isset($_SESSION["cart"])) {
			$productId_Array = array_column($_SESSION["cart"], "idProdusKey");
			// var_dump($productId_Array);

			if(in_array($_POST["id-produs"], $productId_Array)) {
				echo "<script>alert('Produsul a fost deja adaugat in cos!')</script>";
				echo "<script>window.location = 'rezultateProdDupaCateg.php'</script>";
			} else {
				$count = count($_SESSION["cart"]); 
				$productId_Array = array('idProdusKey' => $_POST['id-produs']);

				$_SESSION["cart"][$count] = $productId_Array;
			}

		} else {
			$productIdArray = array('idProdusKey' => $_POST['id-produs']);
			$_SESSION["cart"][0] = $productIdArray;
		}
    }
    
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
<title>Magazin muzica</title>
</head>
<body>
    <div class="container mainContent">
        <div class="text-center">
            <header class="mainHeader"><?php require_once("header.php"); ?></header>
            <br>
            <h2>Rezultatele cautarii:</h2>
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
                        if(isset($_POST['select-categorie-produs'])) { 
                            $categProdus = intval($_POST['select-categorie-produs']);
                        }

                        if(isset($categProdus)) {
                            $_SESSION['select-categorie-produs'] = $categProdus; // save the value is session for access after adding something to cart
                        }

                        $gestiuneProduse = new GestiuneProduse();
                        $gc = new GestiuneCategorii();

                        if(isset($categProdus)) {
                            $produse = $gestiuneProduse->getProduseDupaCategorie($categProdus);
                        } else {
                            $produse = $gestiuneProduse->getProduseDupaCategorie($_SESSION['select-categorie-produs']);
                        }

                        foreach($produse as $key => $produs): 
                    ?>

                    <tr>
                        <td><?= $produs->getIdProdus() ?></td>
                        <td><?= $produs->getDenumireProdus() ?></td>
                        <td><?= $gc->getNumeCategorie($produs->getIdCategorie()) ?></td>
                        <td><?= $produs->getPret() ?></td>
                        <td><?= $produs->getSku() ?></td>
                        <td><?= $produs->getStoc() ?></td>
                        <td>
                            <form id='cumparareProdus' action='rezultateProdDupaCateg.php' method='post'>
                                <input type="hidden" id="id-produs" name="id-produs" value="<?= $produs->getIdProdus(); ?>" >
                                <input type='submit' name='add-to-cart' value='Adauga in cos' class='btn btn-primary'>
                            </form>
                        </td>

                        <?php
								if(isset($_SESSION['cod-utilizator-autentificat'])):
									if($_SESSION['cod-utilizator-autentificat'] == 1):
                        ?>

                        <td><a href="index.php?action=delete&id=<?= $produs->getIdProdus() ?>" class="btn btn-danger">Stergere</a></td>

                        <?php 
                            endif; 
                            endif;
                        ?>
                    </tr>

                    <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>

            <div class="buttonSection">
                <a href="index.php" class="btn btn-primary">Inapoi la prima pagina</a>
            </div>
        </div>
    </div>
    
    <script src="scripts/logout-confirm.js"></script>
</body>
</html>      