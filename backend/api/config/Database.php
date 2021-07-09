<?php

class Database
{
    public $conn;
    private $host = 'localhost';
    private $dbName = 'secretserver';
    //private $host = 'serumcode.com';
    
    //private $dbName = 'lsnrekwj_secretserver';
    private $username = 'root';
    private $password = '';
    //private $username = 'lsnrekwj_serumcode';
    //private $password = 'dDvZEn2nCmNs5NV';
//nemtom volte jelszó
    public function GetConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $ex) {
            echo "Csatlakozási hiba: " . $ex->getMessage();
        }
        return $this->conn;
    }

    public function valueExists($tableName, $column, $val)
    {
        try {
            $query = ("SELECT {$column} FROM {$tableName} WHERE {$column} = :val");
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':val', $val, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if ($result != false)
                return true;
        } catch (PDOException $ex) {
            echo json_encode(retEx($ex->getMessage()));
        } catch (Exception $ex) {
            echo json_encode(retEx($ex->getMessage()));
        }
        return false;
    }


   

}