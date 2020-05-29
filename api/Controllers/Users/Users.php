<?php

require_once __DIR__ . '/../../../utilities/Connection.php';
use Utilities\Connection\Connection;

/**
 * Users list controller
 */
class Users{

    protected $usersList = array();

    /**
     * Constructor
     */
    function __construct(){ }

    /**
     * Get list of 10 first users
     */
    function getList(){
        $adminConnection = new Connection();
        $connection = $adminConnection->getConnection();
        $query = "SELECT name, fullname, email, role, creationDate FROM users LIMIT 10";
        $result = $connection->query($query);
        while($row = $result->fetch_assoc()){
            array_push($this->usersList, $row);
        }
        $adminConnection->close();
        return $this->usersList;
    }

}