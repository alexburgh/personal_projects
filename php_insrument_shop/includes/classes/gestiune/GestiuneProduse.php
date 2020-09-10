<?php

    require_once(__DIR__ . '/../modele/Produs.php');
    require_once(__DIR__ . '/../../database_handler.inc.php');

    class GestiuneProduse {
        
        // method to get all the products
        public function getProduseMagazin() {
            $produse = array();

            $sql = "SELECT id_produs, den, id_categorie, pret, sku, stoc FROM PRODUS;";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->execute();
            $resultCheck = $stmt->rowCount();

            if($resultCheck > 0) { // check if any table rows were selected
                while($row = $stmt->fetch()) { // every row is passed to an array 
                    $idProdus = $row['id_produs'];
                    $denProdus = $row['den'];
                    $idCategorie = $row['id_categorie'];
                    $pret = $row['pret'];
                    $sku = $row['sku'];
                    $stoc = $row['stoc'];

                    $produs = new Produs($idProdus, $denProdus, $idCategorie, $pret, $sku, $stoc);
                    $produse[] = $produs;
                }
            }

            return $produse;
        }

        // method to get products with a specified name
        public function getProduseDupaNume($denProdus) {
            $produseDupaNume = array();
            $denProdusVar = "%{$denProdus}%"; // pentru a putea gasi rezultate si fara a introduce numele exact al produsului

            $sql = "SELECT id_produs, den, id_categorie, pret, sku, stoc FROM PRODUS WHERE DEN LIKE :denumire;";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':denumire', $denProdusVar);
            $stmt->execute();
            $resultCheck = $stmt->rowCount();

            if($resultCheck > 0) {
                while($row = $stmt->fetch()) {
                    $idProdus = $row['id_produs'];
                    $denProdus = $row['den'];
                    $idCategorie = $row['id_categorie'];
                    $pret = $row['pret'];
                    $sku = $row['sku'];
                    $stoc = $row['stoc'];

                    $produs = new Produs($idProdus, $denProdus, $idCategorie, $pret, $sku, $stoc);

                    $produseDupaNume[] = $produs;
                }
            }

            return $produseDupaNume;
        }

        // method to get products with a particular category
        public function getProduseDupaCategorie($idCategProdus) {
            $produseDupaCategorie = array();

            $sql = "SELECT id_produs, den, id_categorie, pret, sku, stoc FROM PRODUS, CATEGORIE WHERE CATEGORIE.ID_CAT = PRODUS.ID_CATEGORIE AND CATEGORIE.ID_CAT = :id_categorie;";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(":id_categorie", $idCategProdus);
            $stmt->execute();
            $resultCheck = $stmt->rowCount();

            if($resultCheck > 0) {
                while($row = $stmt->fetch()) {
                    $idProdus = $row['id_produs'];
                    $denProdus = $row['den'];
                    $idCategorie = $row['id_categorie'];
                    $pret = $row['pret'];
                    $sku = $row['sku'];
                    $stoc = $row['stoc'];

                    $produs = new Produs($idProdus, $denProdus, $idCategorie, $pret, $sku, $stoc);

                    $produseDupaCategorie[] = $produs;
                }
            }

            return $produseDupaCategorie;
        }

        // method to get products with a particular id
        public function getProdusDupaId($idProdus) {
            $sql = "SELECT id_produs, den, id_categorie, pret, sku, stoc FROM PRODUS WHERE PRODUS.ID_PRODUS = :id_produs_bind;";

            $stmt = $GLOBALS['conn']->prepare($sql); 
            $stmt->bindParam(":id_produs_bind", $idProdus); 

            $stmt->execute(); 
            $resultCheck = $stmt->rowCount();

            if($resultCheck > 0) {
                while($row = $stmt->fetch()) {
                    $idProdus = $row['id_produs'];
                    $denProdus = $row['den'];
                    $idCategorie = $row['id_categorie'];
                    $pret = $row['pret'];
                    $sku = $row['sku'];
                    $stoc = $row['stoc'];

                    $produs = new Produs($idProdus, $denProdus, $idCategorie, $pret, $sku, $stoc);
                }
            }

            return $produs; 
        }

        // method to get a specific product 
        public function getProdus($idProdus, $denProdus, $idCategorie, $pretProdus, $skuProdus, $stocProdus) {
            $sql = "SELECT id_produs, den, id_categorie, pret, sku, stoc FROM PRODUS WHERE id_produs = :id_produs AND den = :den AND id_categorie = :id_cat AND pret = :pret AND sku = :sku AND stoc = :stoc;";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':id_produs', $idProdus);
            $stmt->bindParam(':den', $denProdus);
            $stmt->bindParam(':id_cat', $idCategorie);
            $stmt->bindParam(':pret', $pretProdus);
            $stmt->bindParam(':sku', $skuProdus);
            $stmt->bindParam(':stoc', $stocProdus);

            $stmt->execute();
            $resultCheck = $stmt->rowCount();

            if($resultCheck > 0) {
                while($row = $stmt->fetch) {
                    $idProdus = $row['id_produs'];
                    $denProdus = $row['den'];
                    $idCategorie = $row['id_categorie'];
                    $pret = $row['pret'];
                    $sku = $row['sku'];
                    $stoc = $row['stoc'];

                    $produs = new Produs($idProdus, $denProdus, $idCategorie, $pret, $sku, $stoc);
                }
            }

            return $produs;
        }

        // method to decrease the stock of a product 
        public function decreaseStock($idProdus, $stocScazut) {
            $sql = "UPDATE PRODUS SET STOC = STOC - :stoc WHERE ID_PRODUS = :idProdus_bind;";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':stoc', $stocScazut);
            $stmt->bindParam(':idProdus_bind', $idProdus);

            $stmt->execute(); 
        }

        // method to increase the stock of a product
        public function increaseStock($idProdus, $stocScazut) {
            $sql = "UPDATE PRODUS SET STOC = STOC + :stoc WHERE ID_PRODUS = :idProdus_bind;";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':stoc', $stocScazut);
            $stmt->bindParam(':idProdus_bind', $idProdus);

            $stmt->execute(); 
        }

        // method to insert new product
        public function insertProduct($den, $pret, $idCategorie, $sku, $stoc) {
            $sql = "INSERT INTO PRODUS(DEN, PRET, ID_CATEGORIE, SKU, STOC) 
                    VALUES(:den, :pret, :idCategorie, :sku, :stoc);";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':den', $den);
            $stmt->bindParam(':pret', $pret);
            $stmt->bindParam(':idCategorie', $idCategorie);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':stoc', $stoc);

            $stmt->execute();
        }


        public function deleteProduct($idProdus) {
            $sql = "DELETE FROM PRODUS 
                    WHERE ID_PRODUS = :id_produs;";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':id_produs', $idProdus);

            $stmt->execute();
        }


        public function updateProduct($idProdus, $den, $pret, $idCategorie, $sku, $stoc) {
            $sql = "UPDATE produs
                    SET DEN = :den, PRET = :pret, ID_CATEGORIE = :idCateg, SKU = :sku, STOC = :stoc
                    WHERE ID_PRODUS = :idProdus";

            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(':idProdus', $idProdus);
            $stmt->bindParam(':den', $den);
            $stmt->bindParam(':pret', $pret);
            $stmt->bindParam(':idCateg', $idCategorie);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':stoc', $stoc);

            $stmt->execute();
        }
    }


