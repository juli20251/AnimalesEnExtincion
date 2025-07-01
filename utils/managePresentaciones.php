<?php
require_once 'Database.php';
require_once '../Class/Presentaciones.php';
require_once 'ManageArea.php';
require_once 'ManageCuidador.php';

class ManagePresentaciones {
    protected $database;
    protected $pdo;
    protected $manageArea;
    protected $manageCuidador;

    public function __construct() {
        $this->database = new Database();
        $this->pdo = $this->database->connect();
        $this->manageArea = new ManageArea();
        $this->manageCuidador = new ManageCuidador();
    }

    public function getPresentaciones(): array {
        $sql = "SELECT * FROM presentaciones";
        $query = $this->pdo->query($sql);

        $presentaciones = $query->fetchAll();
        $presentaciones_return = [];
        foreach ($presentaciones as $presentacion) {
            $area = $this->manageArea->getArea($presentacion['id_area']);
            $cuidador = $this->manageCuidador->getCuidador($presentacion['id_cuidador']);
            $presentaciones_return[] = new Presentaciones(
                $presentacion['id_presentacion'],
                $area,
                $cuidador,
                $presentacion['tipo'],
                $presentacion['duracion']
            );
        }
        return $presentaciones_return;
    }

    public function getPresentacion(int $id_presentacion): ?Presentaciones {
        $sql = "SELECT * FROM presentaciones WHERE id_presentacion = :id_presentacion";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_presentacion', $id_presentacion, PDO::PARAM_INT);
        $stmt->execute();
        $presentacion = $stmt->fetch();

        if ($presentacion) {
            $area = $this->manageArea->getArea($presentacion['id_area']);
            $cuidador = $this->manageCuidador->getCuidador($presentacion['id_cuidador']);
            return new Presentaciones(
                $presentacion['id_presentacion'],
                $area,
                $cuidador,
                $presentacion['tipo'],
                $presentacion['duracion']
            );
        }
        return null;
    }
}
