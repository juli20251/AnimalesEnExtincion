<?php
require_once 'Area.php';
require_once 'Cuidador.php';

class Presentaciones{
        protected int $idPresentacion;
        protected Area $id_area;
        protected Cuidador $id_Cuidador;
        protected string $tipo;
        protected int $duracion;

        public function __construct(int $idPresentacion, Area $id_area, Cuidador $id_Cuidador, string $tipo, int $duracion){
            $this -> idPresentacion = $idPresentacion;
            $this -> id_area = $id_area;
            $this -> id_Cuidador = $id_Cuidador;
            $this -> duracion = $duracion;
            $this -> tipo = $tipo;
        }

        public function getIdPresentacion(){
            return $this -> IdPresentacion;
        }

        public function getTipo(){
            return $this -> tipo;
        }

        public function getId_area(){
            return $this -> id_area;
        }
        
        public function getDuracion(){
            return $this -> duracion;
        }

        public function getCuidador(): Cuidador {
            return $this->id_Cuidador;
        }
    }
?>