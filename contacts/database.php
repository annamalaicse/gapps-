<?php

class Database
{
    private $db;
    private $connection;
    public $data;
    // Constructor - open DB connection
    function __construct()
    {
        $this->connection = mysqli_connect('localhost', 'root', '', 'gingerpayments');
        mysqli_set_charset($this->connection, 'utf8');
    }
    
    // Destructor - close DB connection
    function __destruct()
    {
        
    }
    
    function findRecords($query, $field_name = null)
    {
        
        $result = $this->connection->query($query);
        
        if ($result->num_rows > 0) {
            
            if (!empty($field_name)) {
                return array_column(mysqli_fetch_all($result, MYSQLI_ASSOC), $field_name);
            }
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // $result->fetch_assoc();
            
        }
        return false;
        ;
    }
    
    function insertRecords($query)
    {
        $result = $this->connection->query($query);
        return mysqli_insert_id($this->connection);
        //return $result;
    }
    function updateRecords($query)
    {
        $result = $this->connection->query($query);
        if ($this->connection->connect_errno) {
            return false;
        }
        return true;
    }
    // Main method to redeem a code
    function redeem()
    {
        // Print all codes in database
        $stmt = $this->db->prepare('SELECT id, code, unlock_code, uses_remaining FROM rw_promo_code');
        $stmt->execute();
        $stmt->bind_result($id, $code, $unlock_code, $uses_remaining);
        while ($stmt->fetch()) {
            echo "$code has $uses_remaining uses remaining!";
        }
        $stmt->close();
    }
}
?>