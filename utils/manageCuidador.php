<?php
require_once 'Database.php';
require_once '../Class/Cuidador.php';

class ManageCuidador {
    protected $database;
    protected $pdo;

    public function __construct() {
        $this->database = new Database();
        $this->pdo = $this->database->connect();
    }

    public function getCuidadores(): array {
        $sql = "SELECT * FROM cuidador";
        $query = $this->pdo->query($sql);

        $cuidadores = $query->fetchAll();
        $cuidadores_return = [];
        foreach ($cuidadores as $cuidador) {
            $cuidadores_return[] = new Cuidador(
                $cuidador['id_cuidador'],
                $cuidador['telefono'],
                $cuidador['nombre'],
                $cuidador['email'],
                null 
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
            return new Cuidador(
                $cuidador['id_cuidador'],
                $cuidador['telefono'],
                $cuidador['nombre'],
                $cuidador['email'],
                null 
            );
        }
        return null;
    }
}
