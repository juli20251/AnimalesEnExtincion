<?php
require_once 'Cuidador.php';

class Area{

    protected int $idArea;
    protected Cuidador $id_cuidador;
    protected string $tipoHabitat;
    
    public function __construct(int $idArea, string $tipoHabitat){
        $this->idArea = $idArea;
        $this->tipoHabitat = $tipoHabitat;
    }
    public function GetID(){
       return $this->idArea;
    }
    public function GetIdCuidador(){
       return $this->id_cuidador;
    }
    public function GetTipoHabitat(){
       return $this->tipoHabitat;
    }
    public function SetCuidador(Cuidador $cuidador){
       return $this->id_cuidador = $cuidador;
    }
}

?>