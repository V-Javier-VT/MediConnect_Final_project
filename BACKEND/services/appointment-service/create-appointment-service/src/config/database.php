<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Database {
    private $pg_host;
    private $pg_port;
    private $pg_db;
    private $pg_user;
    private $pg_password;

    private $mysql_host;
    private $mysql_db;
    private $mysql_user;
    private $mysql_password;

    public $pg_conn;
    public $mysql_conn;

    public function __construct() {
        // PostgreSQL Config
        $this->pg_host = $_ENV['PG_HOST'];
        $this->pg_port = $_ENV['PG_PORT'];
        $this->pg_db = $_ENV['PG_DATABASE'];
        $this->pg_user = $_ENV['PG_USER'];
        $this->pg_password = $_ENV['PG_PASSWORD'];

        // MySQL Config
        $this->mysql_host = $_ENV['MYSQL_HOST'];
        $this->mysql_db = $_ENV['MYSQL_DATABASE'];
        $this->mysql_user = $_ENV['MYSQL_USER'];
        $this->mysql_password = $_ENV['MYSQL_PASSWORD'];
    }

    // ✅ Método correcto para conectar a PostgreSQL
    public function connectPostgres() {
        try {
            $dsn = "pgsql:host={$this->pg_host};port={$this->pg_port};dbname={$this->pg_db}";
            $this->pg_conn = new PDO($dsn, $this->pg_user, $this->pg_password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $this->pg_conn;
        } catch (PDOException $e) {
            die(json_encode(["error" => "Error de conexión a PostgreSQL: " . $e->getMessage()]));
        }
    }

    // ✅ Método correcto para conectar a MySQL
    public function connectMySQL() {
        try {
            $dsn = "mysql:host={$this->mysql_host};dbname={$this->mysql_db};charset=utf8";
            $this->mysql_conn = new PDO($dsn, $this->mysql_user, $this->mysql_password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $this->mysql_conn;
        } catch (PDOException $e) {
            die(json_encode(["error" => "Error de conexión a MySQL: " . $e->getMessage()]));
        }
    }
}
?>
