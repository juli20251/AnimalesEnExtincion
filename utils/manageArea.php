<?php
require_once 'Database.php';
require_once __DIR__ . '/../Class/Area.php';

class ManageArea {
    protected $database;
    protected $pdo;

    public function __construct() {
        $this->database = new Database();
        $this->pdo = $this->database->connect();
    }

    public function getArea(int $idArea): ?Area {
        $sql = "SELECT * FROM area WHERE id_area = :id_area";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_area', $idArea, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            return new Area($row['id_area'], $row['tipohabitad']);
        }
        return null;
    }

    public function getAreas(): array {
        $sql = "SELECT * FROM area";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $areas = [];

        while ($row = $stmt->fetch()) {
            $areas[] = new Area($row['id_area'], $row['tipohabitad']);
        }

        return $areas;
    }
}
?>
