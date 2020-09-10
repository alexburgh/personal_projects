<?php 

    require_once(__DIR__ . '/../modele/Categorie.php');
    require_once(__DIR__ . '/../../database_handler.inc.php');

    class GestiuneCategorii {

        public function getCategorii() {
            $categorii = array();

            $sql = "SELECT id_cat, denumire FROM categorie ORDER BY denumire ASC";
            $stmt = $GLOBALS['conn']->prepare($sql); // using GLOBALS[] in order to gain access to global variable conn, from the file required at the beginning
            $stmt->execute();
            $resultCheck = $stmt->rowCount();

            if($resultCheck > 0) { // check if any table rows were selected
                while($row = $stmt->fetch()) {
                    $idCategorie = $row['id_cat'];
                    $denCategorie = $row['denumire'];

                    $categorie = new Categorie($idCategorie, $denCategorie);
                    $categorii[] = $categorie;
                }
            }

            return $categorii;
        }
        
        public function getNumeCategorie($idCategorie) {
            $sql = "SELECT id_cat, denumire FROM categorie WHERE id_cat = :id_categ;";
            $stmt = $GLOBALS['conn']->prepare($sql);
            $stmt->bindParam(":id_categ", $idCategorie);
            $stmt->execute();
            $resultCheck = $stmt->rowCount();

            if($resultCheck > 0) {
                while($row = $stmt->fetch()) {
                    $denCategorie = $row['denumire'];
                }
            }

            return $denCategorie;
        }
    }