<?php   

    class Tranzactie {

        private $idTranzactie;
        private $data;
        private $suma;
        private $id_produs;
        private $id_livrare;

        public function __construct($idTranzactie, $data, $suma, $id_produs, $id_livrare) {
            $this->idTranzactie = $idTranzactie;
            $this->data = $data;
            $this->suma = $suma;
            $this->id_produs = $id_produs;
            $this->id_livrare = $id_livrare;
        }

        public function getIdTranzactie() {
            return $this->idTranzactie;
        }

        public function getData() {
            return $this->data;
        }

        public function getSuma() {
            return $this->suma;
        }
        
        public function getIdProdus() {
            return $this->id_produs;
        }

        public function getIdLivrare() {
            return $this->id_livrare;
        }

    }