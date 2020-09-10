<?php 
    class Categorie {
        private $idCategorie;
        private $denCategorie;

        public function __construct($idCategorie, $denCategorie) {
            $this->idCategorie = $idCategorie;
            $this->denCategorie = $denCategorie;
        }

        public function getIdCategorie() {
            return $this->idCategorie;
        }

        public function getDenCategorie() {
            return $this->denCategorie;
        } 

        public function setDenCategorie($denCategorie) {
            $this->denCategorie = $denCategorie;
        }
    }