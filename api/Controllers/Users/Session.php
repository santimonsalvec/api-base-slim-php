<?php
require_once __DIR__ . '/../../../utilities/Connection.php';
require_once __DIR__ . '/../../../environments/environments.php';
use Utilities\Connection\Connection;
use Firebase\JWT\JWT;

/**
 * User session
 */
class Session{

    protected $email;
    protected $fullname;
    protected $role;
    protected $name;
    protected $token;
    protected $token_iat;
    protected $token_exp;
    protected $exist = false;

    /**
     * Constructor
     * @param string $username
     * @param string $password
     */
    function __construct($username, $password){
        
        $adminConnection = new Connection();
        $connection = $adminConnection->getConnection();
        $query = "SELECT * FROM users WHERE email = '$username' AND password = '" . md5($password) . "' LIMIT 1";
        $result = $connection->query($query);
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $this->email = $data['email'];
            $this->fullname = $data['fullname'];
            $this->role = $data['role'] ;
            $this->name = $data['name'] ;
            $this->token_iat = date("Y-m-d H:i:s");
            $this->token_exp = date("Y-m-d H:i:s", strtotime('+5 hours'));
            $this->token = $this->getToken();
            $this->exist = true;
        }
        $adminConnection->close();
    }

    /**
     * Generate token
     */
    private function getToken(){
        global $jwt_secret;
        $payload = array(
            "sub" => $this->email,
            "name" => $this->name,
            "iat" => $this->token_iat,
            "exp" => $this->token_exp
        );
        
        $token = JWT::encode(json_encode($payload), $jwt_secret, 'HS256');
        return $token;
    }

    /**
     * Validate if user was founded
     */
    function exist(){
        return $this->exist;
    }

    /**
     * Get session data
     */
    function getData(){
        $data = array(
            'email' => $this->email,
            'fullname' => $this->fullname,
            'role' => $this->role,
            'name' => $this->name,
            'token' => $this->token,
            'tokenExpiration' => $this->token_exp
        );

        return $data;
    }

}