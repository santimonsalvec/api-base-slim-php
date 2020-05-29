<?php

namespace Utilities\Connection;
require_once '../environments/environments.php';

/**
 * Manager of connections MySql
 */
class Connection{
    private $db_prod = array(
        'host' => '127.0.0.1:3306', // inlclude the port if not work
        'name' => 'database_name',
        'user' => 'admin',
        'password' => 'admin'
    );
    private $db_test = array(
        'host' => '127.0.0.1:3306', // inlclude the port if not work
        'name' => 'database_name',
        'user' => 'admin',
        'password' => 'admin'
    );
    private $connection;

    /**
     * Constructor
     */
    function __construct(){
        global $productionMode;
        if($productionMode == 'true'){
            $this->connection = mysqli_connect($this->db_prod['host'], $this->db_prod['user'], $this->db_prod['password'], $this->db_prod['name']);
        }else{
            $this->connection = mysqli_connect($this->db_test['host'], $this->db_test['user'], $this->db_test['password'], $this->db_test['name']);
        }
        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->connection->connect_error;
            exit();
        }
        $this->connection->set_charset("utf8");
    }

    /**
     * Get connection
     */
    function getConnection(){
        return $this->connection;
    }

    /**
     * Close connection
     */
    function close(){
        $this->connection->close();
    }

}