<?php
require_once 'Area.php';
require_once 'Cuidador.php';

class Presentaciones {
    protected int $idPresentacion;
    protected Area $area;
    protected Cuidador $cuidador;
    protected string $tipo;
    protected int $duracion;

    public function __construct(int $idPresentacion, Area $area, Cuidador $cuidador, string $tipo, int $duracion) {
        $this->idPresentacion = $idPresentacion;
        $this->area = $area;
        $this->cuidador = $cuidador;
        $this->tipo = $tipo;
        $this->duracion = $duracion;
    }

    public function getIdPresentacion(): int {
        return $this->idPresentacion;
    }

    public function getArea(): Area {
        return $this->area;
    }

    public function getCuidador(): Cuidador {
        return $this->cuidador;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getDuracion(): int {
        return $this->duracion;
    }
}
?>
