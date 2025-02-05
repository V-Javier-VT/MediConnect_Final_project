<?php
use PDO;
use PDOException;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Database {
    private $pg_host, $pg_port, $pg_db, $pg_user, $pg_password;
    public $pg_conn;

    public function __construct() {
        $this->pg_host = $_ENV['PG_HOST'];
        $this->pg_port = $_ENV['PG_PORT'];
        $this->pg_db = $_ENV['PG_DATABASE'];
        $this->pg_user = $_ENV['PG_USER'];
        $this->pg_password = $_ENV['PG_PASSWORD'];
    }

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
}
?>
