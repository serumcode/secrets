<?php

class Secret
{
    #region properties
    public $id;
    public $expireAfterViews;
    public $expireAfter;
    public $secret;
    public $hash;
    public $views;
    public $tableName = "secrets";
    #endregion

    #region constructor

    public function __construct($db)
    {
        $this->conn = $db;
    }
    #endregion

    #region methods
    public function createSecret()
    {
        try {
            $query = "INSERT INTO {$this->tableName} (expireAfterViews, expireAfter, secret, hash, date) VALUES (:expireAfterViews, :expireAfter, :secret, :hash, :date)";
            $stmt = $this->conn->prepare($query);
            
//            sanitizeObject($this);
           
            
             
            $stmt->bindValue(':expireAfterViews', $this->expireAfterViews, PDO::PARAM_INT);
            $stmt->bindValue(':expireAfter', $this->expireAfter, PDO::PARAM_INT);
            $stmt->bindValue(':secret', $this->secret, PDO::PARAM_STR);
            $stmt->bindValue(':hash', $this->hash, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
           
            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $ex) {
            echo json_encode(retEx($ex->getMessage()));
        } catch (Exception $ex) {
            echo json_encode(retEx($ex->getMessage()));
        }
    }

   
    public function getSecret()
    {
        try {
//            sanitizeObject($this);
            $stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE hash = :hash");
            $stmt->bindValue(':hash', $this->hash, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $secretData = $stmt->fetch(PDO::FETCH_OBJ);
                if ($secretData) {
                    $this->id = $secretData->id;
                    $this->expireAfterViews = $secretData->expireAfterViews;
                    $this->expireAfter = $secretData->expireAfter;
                    $this->secret = $secretData->secret;
                    $this->date = $secretData->date;
                    $this->views=$secretData->views;
                    return true;
                }
                else
                return false;
            } else
                return false;
        } catch (PDOException $ex) {
            echo json_encode(retEx($ex->getMessage()));
        } catch (Exception $ex) {
            echo json_encode(retEx($ex->getMessage()));
        }
    }
     public function updateSecret()
    {
        try {
            $query = "UPDATE {$this->tableName} SET views = :views WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            sanitizeObject($this);
            $stmt->bindParam(':views', (intval($this->views+1)));
            //$stmt->bindParam(':views', (int($this->views+1)), PDO::PARAM_INT);
            $stmt->bindParam(':id', $this->id);
            if ($stmt->execute())
                return true;

            return false;
        } catch (PDOException $ex) {
            echo json_encode(retEx($ex->getMessage()));
        } catch (Exception $ex) {
            echo json_encode(retEx($ex->getMessage()));
        }
    }
  

}
