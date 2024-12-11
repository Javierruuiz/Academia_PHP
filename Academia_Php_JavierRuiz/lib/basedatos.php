<?php
namespace lib;
use PDO;
use PDOException;

class BaseDatos
{
    private ?PDO $conexion;
    private mixed $result;
    private string $server;
    private string $user;
    private string $pass;
    private string $data_base;
    function __construct()
    {
        $this->server = SERVIDOR;
        $this->user = USUARIO;
        $this->pass = PASSWORD;
        $this->data_base = BASE_DATOS;
        $this->conexion = $this->conect();

    }
    function conect() : PDO {
        try {
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );
            $conexion = new PDO("mysql:host={$this->server};dbname={$this->data_base}",$this->user,$this->pass,$opciones);
            return $conexion;
        } catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar con la base de datos".$e->getMessage();
            exit;
        }
    }
    public function querySQL(string $querySQL) : void {
        $this->result = $this->conexion->query($querySQL);
    }
    public function register() :array {
        return ($fila = $this->result->fetch(PDO::FETCH_ASSOC))?$fila:false;
    }
    public function allRegister():array {
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function prepare(string $querySQL) {
        return $this->conexion->prepare($querySQL);
    }
    public function close():void{
        $this->conexion=null;
        }
}