<?php

namespace Hotel;

// WE are in a namespace and PDO is a global object
use PDO;
use Hotel\BaseService;

class RoomType extends BaseService{
    
    //Returns all the roomTypes
    public function getAllTypes(){

        //Get roomTypes
        return $this->fetchAll('SELECT DISTINCT * FROM room_type');
    }
}