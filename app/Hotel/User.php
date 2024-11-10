<?php

namespace Hotel;

// WE are in a namespace and PDO is a global object
use PDO;
use Hotel\BaseService;

class User extends BaseService{

    // Signing key
    const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';
    private static $currentUserId;

    public static function getCurrentUserId(){
        return self::$currentUserId;
    }

    public static function setCurrentUserId($userId){
        self::$currentUserId = $userId;
    }

    // Get list of users
    public function getList(){

        return $this->fetchAll('SELECT * FROM user');
    }
    // Get user by email
    public function getByEmail($email){

        $parameters = [
            ':email' => $email,
        ];
        return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
    }

    //Insert a user
    public function insert($name, $password, $email){

        // Hashing password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //Prepare parametres
        $parameters = [
            ':name' => $name,
            ':email'=> $email,
            ':password'=> $passwordHash
        ];

        $rows = $this->execute('INSERT INTO user(name, email, password) VALUES (:name, :email, :password)', $parameters);

        return $rows == 1;
    }

    // Verify user
    public function verify($email, $password){

        // Step 1 - Retrieve user
        $user = $this->getByEmail($email);

        // Step 2 - Verify User
        return password_verify($password, $user['password']);
    }

    //Generate Token
    public function generateToken($userId, $csrf = '')
    {
        // Create token payload
        $payload = [
            'user_id' => $userId,
            'csrf' => $csrf ?: md5(time())
        ];
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

        return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    //Verify Token
    public static function getTokenPayload($token)
    {
        // Get payload and signature
        [$payloadEncoded] = explode('.', $token);

        // Get payload
        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token)
    {
        // Get payload
        $payload = $this->getTokenPayload($token);
        $userId = $payload['user_id'];
        $csrf = $payload['csrf'];

        // Generate signature and verify
        return $this->generateToken($userId, $csrf) == $token;
    }

    public static function getCSRF()
    {
        $token = $_COOKIE['user_token'];

        // Get payload
        $payload = self::getTokenPayload($token);
        
        return $payload['csrf'];
    }

    public static function verifyCSRF($csrf)
    {
        return $csrf == self::getCSRF();
    }
}

?>