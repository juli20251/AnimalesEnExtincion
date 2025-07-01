<?php
require_once 'Database.php';
require_once '../Class/Especies.php';
require_once 'ManageArea.php';

class ManageEspecies {
    protected $database;
    protected $pdo;
    protected $manageArea;

    public function __construct() {
        $this->database = new Database();
        $this->pdo = $this->database->connect();
        $this->manageArea = new ManageArea();
    }

    public function getEspecies(): array {
        $sql = "SELECT * FROM especies";
        $query = $this->pdo->query($sql);

        $especies = $query->fetchAll();
        $especies_return = [];
        foreach ($especies as $especie) {
            $area = $this->manageArea->getArea($especie['id_area']);
            $especies_return[] = new Especies(
                $especie['id_especies'],
                $area,
                $especie['nombre'],
                $especie['cantidadHembras'],
                $especie['cantidadMachos']
            );
        }
        return $especies_return;
    }

    public function getEspecie(int $id_especies): ?Especies {
        $sql = "SELECT * FROM especies WHERE id_especies = :id_especies";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_especies', $id_especies, PDO::PARAM_INT);
        $stmt->execute();
        $especie = $stmt->fetch();

        if ($especie) {
            $area = $this->manageArea->getArea($especie['id_area']);
            return new Especies(
                $especie['id_especies'],
                $area,
                $especie['nombre'],
                $especie['cantidadHembras'],
                $especie['cantidadMachos']
            );
        }
        return null;
    }
}
