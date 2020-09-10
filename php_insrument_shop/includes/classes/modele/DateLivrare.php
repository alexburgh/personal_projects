<?php

    class DateLivrare {

        private $idLivrare;
        private $nume;
        private $prenume;
        private $email;
        private $oras;
        private $adresa;
        private $codPostal;
        private $mesaj;

        public function __construct($idLivrare, $nume, $prenume, $email, $oras, $adresa, $codPostal, $mesaj) {
            $this->idLivrare = $idLivrare;
            $this->nume = $nume;
            $this->prenume = $prenume;
            $this->email = $email;
            $this->oras = $oras;
            $this->adresa = $adresa;
            $this->codPostal = $codPostal;
            $this->mesaj = $mesaj;
        }

        public function getIdLivrare() {
            return $this->idLivrare;
        }

        public function getNume() {
            return $this->nume;
        }

        public function getPrenume() {
            return $this->prenume;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getOras() {
            return $this->oras;
        }

        public function getAdresa() {
            return $this->adresa;
        }

        public function getCodPostal() {
            return $this->codPostal;
        }

        public function getMesaj() {
            return $this->mesaj;
        }