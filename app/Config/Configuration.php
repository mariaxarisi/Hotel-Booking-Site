<?php

namespace Config;

//A singleton class
class Configuration{

    private $config;
    private static $instance;

    private function __construct(){
        // Load configuration from environment variables
        $this->config = [
            'database' => [
                'host' => getenv('DB_HOST'),
                'dbname' => getenv('DB_NAME'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD')
            ]
        ];
    }

    public function getConfig(){
        return $this->config;
    }

    public static function getInstance(){
        self::$instance = self::$instance ?: new Configuration();
        return self::$instance;
    }
}
?>