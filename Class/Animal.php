<?php
require_once 'Especies.php';

class Animal {
    protected int $idAnimal;
    protected Especies $especie;
    protected string $nombre;
    protected int $edad;
    protected string $sexo;

    public function __construct(int $idAnimal, Especies $especie, string $nombre, int $edad, string $sexo) {
        $this->idAnimal = $idAnimal;
        $this->especie = $especie;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->sexo = $sexo;
    }

    public function getId(): int {
        return $this->idAnimal;
    }

    public function getEspecie(): Especies {
        return $this->especie;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getEdad(): int {
        return $this->edad;
    }

    public function getSexo(): string {
        return $this->sexo;
    }
}
?>
