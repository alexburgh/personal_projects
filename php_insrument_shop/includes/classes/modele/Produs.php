<?php 

    class Produs {
        private $idProdus;
        private $denumireProdus;
        private $idCategorie;
        private $pret;
        private $sku;
        private $stocProdus;

        public function __construct($idProdus, $denumireProdus, $idCategorie, $pret, $sku, $stocProdus) {
            $this->idProdus = $idProdus;
            $this->denumireProdus = $denumireProdus;
            $this->idCategorie = $idCategorie;
            $this->pret = $pret;
            $this->sku = $sku;
            $this->stocProdus = $stocProdus;
        }

        public function getIdProdus() {
            return $this->idProdus;
        }

        public function setIdProdus($idProdus) {
            $this->idProdus = $idProdus;
        }

        public function getDenumireProdus() {
            return $this->denumireProdus;
        }

        public function setDenumireProdus($denumireProdus) {
            $this->denumireProdus = $denumireProdus;
        }

        public function getIdCategorie() {
            return $this->idCategorie;
        }

        public function setIdCategorie($idCategorie) {
            $this->idCategorie = $idCategorie;
        }

        public function getPret() {
            return $this->pret;
        }

        public function setPret($pret) {
            $this->pret = $pret;
        }

        public function getSku() {
            return $this->sku;
        }

        public function setSku($sku) {
            $this->sku = $sku;
        }  

        public function getStoc() {
            return $this->stocProdus;
        }

        public function setStoc($stocProdus) {
            $this->stocProdus = $stocProdus;
        }

    }