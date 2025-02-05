<?php
use PDO;
use PDOException;
use Dotenv\Dotenv;  // 🔹 Asegúrate de que esta línea está presente

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');  // 🔹 Cargar variables de entorno
$dotenv->load();

class Database {
    private $pg_host, $pg_port, $pg_db, $pg_user, $pg_password;
    private $mysql_host, $mysql_db, $mysql_user, $mysql_password;
    public $pg_conn, $mysql_conn;

    public function __construct() {
        $this->pg_host = $_ENV['PG_HOST'];
        $this->pg_port = $_ENV['PG_PORT'];
        $this->pg_db = $_ENV['PG_DATABASE'];
        $this->pg_user = $_ENV['PG_USER'];
        $this->pg_password = $_ENV['PG_PASSWORD'];

        $this->mysql_host = $_ENV['MYSQL_HOST'];
        $this->mysql_db = $_ENV['MYSQL_DATABASE'];
        $this->mysql_user = $_ENV['MYSQL_USER'];
        $this->mysql_password = $_ENV['MYSQL_PASSWORD'];
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
