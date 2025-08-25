<?php
require_once 'Database.php';
require_once __DIR__ . '/../Class/Cuidador.php';
require_once 'manageArea.php';  // 👈 AGREGÁ ESTA LÍNEA

class ManageCuidador {
    protected $database;
    protected $pdo;
    protected $manageArea;

    public function __construct() {
        $this->database = new Database();
        $this->pdo = $this->database->connect();
        $this->manageArea = new ManageArea();  // 👈 INSTANCIÁLO
    }

    public function getCuidadores(): array {
        $sql = "SELECT * FROM cuidador";
        $query = $this->pdo->query($sql);

        $cuidadores = $query->fetchAll();
        $cuidadores_return = [];

        foreach ($cuidadores as $cuidador) {
            // 👇 Obtenemos el área desde la BD
            $area = $this->manageArea->getArea($cuidador['id_area']);

            $cuidadores_return[] = new Cuidador(
                $cuidador['id_cuidador'],
                $area,  // 👈 Ahora es un objeto Area
                $cuidador['nombre'],
                $cuidador['telefono'],
                $cuidador['email']
            );
        }
        return $cuidadores_return;
    }

    public function getCuidador(int $id_cuidador): ?Cuidador {
        $sql = "SELECT * FROM cuidador WHERE id_cuidador = :id_cuidador";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_cuidador', $id_cuidador, PDO::PARAM_INT);
        $stmt->execute();
        $cuidador = $stmt->fetch();

        if ($cuidador) {
            $area = $this->manageArea->getArea($cuidador['id_area']);

            return new Cuidador(
                $cuidador['id_cuidador'],
                $area,
                $cuidador['nombre'],
                $cuidador['telefono'],
                $cuidador['email']
            );
        }
        return null;
    }
}

?>
