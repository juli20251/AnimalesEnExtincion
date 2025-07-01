<?php
require_once 'Area.php';

class Especies {
    protected int $id_especie;
    protected Area $area;
    protected string $nombre;
    protected int $cantidadMachos;
    protected int $cantidadHembras;
    
    public function __construct(int $id_especie, Area $area, string $nombre, int $cantidadHembras, int $cantidadMachos) {
        $this->id_especie = $id_especie;
        $this->nombre = $nombre;
        $this->area = $area;
        $this->cantidadMachos = $cantidadMachos;
        $this->cantidadHembras = $cantidadHembras;
    }
    
    public function getIdEspecie(): int {
        return $this->id_especie;
    }
    
    public function getNombre(): string {
        return $this->nombre;
    }
    
    public function getArea(): Area {
        return $this->area;
    }
    
    public function getCantidadMachos(): int {
        return $this->cantidadMachos;
    }
    
    public function getCantidadHembras(): int {
        return $this->cantidadHembras;
    }
}
?>
