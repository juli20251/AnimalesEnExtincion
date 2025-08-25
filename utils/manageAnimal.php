<?php
require_once 'Database.php';
require_once __DIR__ . '/../Class/Animal.php';
require_once __DIR__ . '/manageEspecies.php';

class ManageAnimal {
    protected $database;
    protected $pdo;
    protected $manageEspecies;

    public function __construct() {
        $this->database = new Database();
        $this->pdo = $this->database->connect();
        $this->manageEspecies = new ManageEspecies();
    }

    public function getAnimales(): array {
        $sql = "SELECT * FROM animal";
        $query = $this->pdo->query($sql);

        $animales = $query->fetchAll();
        $animales_return = [];

        foreach ($animales as $animal) {
            $especie = $this->manageEspecies->getEspecie($animal['id_especie']);
            $animales_return[] = new Animal(
                $animal['id_animal'],
                $especie,
                $animal['nombre'],
                $animal['edad'],
                $animal['sexo']
            );
        }
        return $animales_return;
    }

    public function getAnimal(int $id_animal): ?Animal {
        $sql = "SELECT * FROM animal WHERE id_animal = :id_animal";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_animal', $id_animal, PDO::PARAM_INT);
        $stmt->execute();
        $animal = $stmt->fetch();

        if ($animal) {
            $especie = $this->manageEspecies->getEspecie($animal['id_especie']);
            return new Animal(
                $animal['id_animal'],
                $especie,
                $animal['nombre'],
                $animal['edad'],
                $animal['sexo']
            );
        }
        return null;
    }
}
?>
