<?php
class Database{
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct() {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->database = 'animalsproyect';
    }

    public function connect() {
        return new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}
