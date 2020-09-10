<?php 
    require_once('includes/classes/gestiune/GestiuneCategorii.php');
    require_once('includes/classes/gestiune/GestiuneProduse.php');

    session_start();

    if(isset($_POST['edit-product']) && ($_SESSION['cod-utilizator-autentificat'] == 1)) {
        $gp = new GestiuneProduse();
        $produs = $gp->getProdusDupaId($_POST['id-produs-editat']);
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="customCSS/style.css" rel="stylesheet" type="text/css"/>
    <title>Actualizare produs</title>
</head>
<body>
    <div class="container update-product-form-maincontainer col-md-4">
        <div class="update-product-container text-center">
            <h5 class="">Actualizare produs</h5>
            <form class="update-product-form" method="post" action="index.php">
                <div class="form-group">
                    <input type="text" name="product-update-name" class="form-control"
                        value="<?= $produs->getDenumireProdus() ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="product-update-price" class="form-control"
                        value="<?= $produs->getPret() ?>">
                </div>
                <div class="form-group">
                    <select class="form-control" name="product-update-category" id="categorie-produs-insert-dropdown">
                        <?php
                            $gc = new GestiuneCategorii();
                            $categories = $gc->getCategorii();

                            foreach($categories as $category):
                        ?>
                        <option value="<?= $category->getIdCategorie() ?>" 
                            <?php if($category->getIdCategorie() == $produs->getIdCategorie()) {
                                    echo 'selected';
                            }?>>
                                    <?= $category->getDenCategorie() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="product-update-sku" class="form-control"
                        value="<?= $produs->getSku() ?>">
                </div>
                <div class="form-group">
                    <input type="number" name="product-update-stock" class="form-control"
                        value="<?= $produs->getStoc() ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" id="updated-product-id" name="updated-product-id" value="<?= $produs->getIdProdus() ?>">
                    <input type="submit" id="update-product" name="update-product" class="btn btn-primary submit-button" value="Actualizare">
                </div>
            </form>
        </div>
    </div> 
</body>
</html>
