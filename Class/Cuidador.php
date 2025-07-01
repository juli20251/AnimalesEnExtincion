<?php
require_once 'Area.php';

class Cuidador {
    protected int $idcui;
    protected Area $id_area;
    protected string $nombre;
    protected int $telefono;
    protected string $email;

    public function __construct(int $idcui, string $nombre, int $telefono, string $email, Area $id_area){
        $this->idcui = $idcui;
        $this->id_area = $id_area;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->email = $email;
    }

    public function getIdCui(): int {
        return $this->idcui;
    }

    public function getIdArea(): Area {
        return $this->id_area;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getTelefono(): int {
        return $this->telefono;
    }

    public function getEmail(): string {
        return $this->email;
    }
}
?>
