<?php

namespace App\DataAccess\Concrete\Pdo;

use PDO;
use PDOException;

class Database // veritabanı bağlantısı örneği singleton pattern
{
    // Veritabanı bağlantısı örneğini tutacak statik bir değişken
    private static $instance = null;
    private $connection;

    // Veritabanı bağlantı ayarları
    private $host = 'db';
    private $dbName = 'laravel';
    private $username = 'root';
    private $password = '';

    // Yapıcı (constructor) private olarak tanımlanır, böylece dışarıdan çağrılamaz.
    private function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbName;charset=utf8", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Veritabanı bağlantı hatası: " . $e->getMessage());
        }
    }

    // Singleton örneğini döndüren statik bir fonksiyon
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Veritabanı bağlantısını döndürür
    public function getConnection()
    {
        return $this->connection;
    }

    // Clone edilmesini önlemek için __clone metodunu private yapıyoruz
    private function __clone()
    {
    }

    // Serileştirilmesini önlemek için __wakeup metodunu private yapıyoruz
    private function __wakeup()
    {
    }
}


$db = Database::getInstance();
$connection = $db->getConnection();
