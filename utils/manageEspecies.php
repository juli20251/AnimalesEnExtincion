<?php
require_once 'Database.php';
require_once __DIR__ . '/../Class/Especies.php';
require_once 'manageArea.php';

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

        foreach ($especies as $esp) {
            $area = $this->manageArea->getArea($esp['id_area']);

            $especies_return[] = new Especies(
                $esp['id_especies'],
                $area,
                $esp['nombre'],
                $esp['cantidadMachos'],
                $esp['cantidadHembras']
            );
        }
        return $especies_return;
    }

    public function getEspecie(int $id): ?Especies {
        $sql = "SELECT * FROM especies WHERE id_especies = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $esp = $stmt->fetch();

        if ($esp) {
            $area = $this->manageArea->getArea($esp['id_area']);

            return new Especies(
                $esp['id_especies'],
                $area,
                $esp['nombre'],
                $esp['cantidadMachos'],
                $esp['cantidadHembras']
            );
        }
        return null;
    }
}
?>
