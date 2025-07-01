<?php
require_once 'Especies.php';

class Animal{

    protected int $idAnimal;
    protected Especies $especie;
    protected string $nombre;
    protected int $edad;
    protected string $sexo;
    
    public function __construct(int $idAnimal, Especies $especie, string $nombre, int $edad, string $sexo){
        $this->idAnimal = $idAnimal;
        $this->nombre = $nombre;
        $this->especie = $especie;
        $this->edad = $edad;
        $this->sexo = $sexo;
    }
    public function GetID(){
       return $this->idAnimal;
    }
    public function GetNombre(){
       return $this->nombre;
    }
    public function GetEspecie(){
       return $this->especie;
    }
    public function GetEdad(){
       return $this->edad;
    }
    public function GetSexo(){
       return $this->sexo;
    }
}

?>