<?php
require_once 'Area.php';

class Especies {
    protected int $id;
    protected Area $area;
    protected string $nombre;
    protected int $cantidadMachos;
    protected int $cantidadHembras;

    public function __construct(int $id, Area $area, string $nombre, int $cantidadMachos, int $cantidadHembras) {
        $this->id = $id;
        $this->area = $area;
        $this->nombre = $nombre;
        $this->cantidadMachos = $cantidadMachos;
        $this->cantidadHembras = $cantidadHembras;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getArea(): Area {
        return $this->area;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getCantidadMachos(): int {
        return $this->cantidadMachos;
    }

    public function getCantidadHembras(): int {
        return $this->cantidadHembras;
    }
}
?>
