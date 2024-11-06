<?php

namespace Config;

//A singleton class
class Configuration{

    private $config;
    private static $instance;

    private function __construct(){
        //Load config.json file
        $filepath = __DIR__.'/../../config/config.json';
        $fileContent = file_get_contents($filepath);
        $this->$config = json_decode($fileContent, true); //true makes the array associative
    }

    public function getConfig(){
        return $this->$config;
    }

    public static function getInstance(){
        self::$instance = self::$instance ?: new Configuration();
        return self::$instance;
    }
}
?>