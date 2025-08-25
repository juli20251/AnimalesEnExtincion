<?php
require_once 'Cuidador.php';

class Area {
    protected int $idArea;
    protected ?Cuidador $cuidador = null;  // puede no estar asignado
    protected string $tipoHabitat;

    public function __construct(int $idArea, string $tipoHabitat) {
        $this->idArea = $idArea;
        $this->tipoHabitat = $tipoHabitat;
    }

    public function getId(): int {
        return $this->idArea;
    }

    public function getCuidador(): ?Cuidador {
        return $this->cuidador;
    }

    public function getTipoHabitat(): string {
        return $this->tipoHabitat;
    }

    public function setCuidador(Cuidador $cuidador): void {
        $this->cuidador = $cuidador;
    }
}
?>
