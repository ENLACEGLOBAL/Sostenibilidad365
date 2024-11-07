<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use PDOException;

class backend extends Model
{

    use HasFactory;
    protected $conn;

    private $servername;
    private $database;
    private $port;
    private $username;
    private $password;

    public $insertar_empleados;
    public $insertar_empresa;

    public function __construct()
    {
        $this->servername = config('backend.host');
        $this->database = config('backend.schema');
        $this->port = config('backend.port');
        $this->username = config('backend.user');
        $this->password = config('backend.pass');
        try {
            $datos = 'mysql:host=' . $this->servername . ';port=' . $this->port . ';dbname=' . $this->database . ';charset=utf8';
            $this->conn = new \PDO($datos, $this->username, $this->password, array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                \PDO::MYSQL_ATTR_SSL_CIPHER => 'ECDHE-ECDSA-AES256-GCM-SHA384'
            ));

            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->declaraciones();
        } catch(\PDOException $e) {
            $respuesta = $e->getMessage();
        }
    }

    private function declaraciones(){
        $this->insertar_empleados = "CALL añadir_empleado(?,?,?,?,?,?,?,?);";
        $this->insertar_empresa = "CALL registar_empresa(?,?);";
    }

    public function insertempleados($p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8)
    {
        try {
            $sql = $this->conn->prepare($this->insertar_empleados);
            $sql->bindParam(1, $p1, \PDO::PARAM_STR);
            $sql->bindParam(2, $p2, \PDO::PARAM_STR);
            $sql->bindParam(3, $p3, \PDO::PARAM_STR);
            $sql->bindParam(4, $p4, \PDO::PARAM_STR);
            $sql->bindParam(5, $p5, \PDO::PARAM_STR);
            $sql->bindParam(6, $p6, \PDO::PARAM_STR);
            $sql->bindParam(7, $p7, \PDO::PARAM_STR);
            $sql->bindParam(8, $p8, \PDO::PARAM_INT); 
            $sql->execute();
        } catch (PDOException $e) {
            throw new Exception('Error inserting empleados: ' . $e->getMessage());
        }
    }

    public function insert_empresa($p1, $p2)
    {
        try {
            $sql = $this->conn->prepare($this->insertar_empresa);
            $sql->bindParam(1, $p1, \PDO::PARAM_STR);
            $sql->bindParam(2, $p2, \PDO::PARAM_STR);
            $sql->execute();
        } catch (PDOException $e) {
            throw new Exception('Error inserting empresa: ' . $e->getMessage());
        }
    }

    
}
