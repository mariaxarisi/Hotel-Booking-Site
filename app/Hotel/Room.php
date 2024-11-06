<?php

namespace Hotel;

// WE are in a namespace and PDO is a global object
use PDO;
use DateTime;
use Hotel\BaseService;

class Room extends BaseService{
    
    //Returns all the cities
    public function getCities(){

        //Get cities
        $rows =  $this->fetchAll('SELECT DISTINCT city FROM room');
        $cities = [];
        foreach($rows as $row){
            $cities[] = $row['city'];
        }

        return $cities;
    }

    //Search a room
    public function searchRoom($city, $typeId, $checkInDate, $checkOutDate){

        $parameters = [
            ':city' => $city,
            ':typeId' => $typeId,
            ':checkInDate'=> $checkInDate->format(DateTime::ATOM),
            ':checkOutDate'=> $checkOutDate->format(DateTime::ATOM)
        ];

        //Get rooms
        return  $this->fetchAll('SELECT * FROM room
                                    WHERE city = :city AND type_id = :typeId AND room_id  NOT IN(
                                    SELECT room_id FROM booking
                                    WHERE check_in_date <= :checkOutDate AND check_out_date >= :checkInDate)', $parameters);
   
    }

    //Search a room extended
    public function searchRoomExtended($city, $typeId, $checkInDate, $checkOutDate, $countOfGuests, $minPrice, $maxPrice){

        if($countOfGuests == 'none'){
            $countOfGuests = $typeId;
        }

        $parameters = [
            ':city' => $city,
            ':typeId' => $typeId,
            ':checkInDate'=> $checkInDate->format(DateTime::ATOM),
            ':checkOutDate'=> $checkOutDate->format(DateTime::ATOM),
            ':countOfGuests' => $countOfGuests,
            ':minPrice' => $minPrice,
            ':maxPrice' => $maxPrice
        ];

        //Get rooms
        return  $this->fetchAll('SELECT * FROM room
                                    WHERE city = :city AND type_id = :typeId AND count_of_guests >= :countOfGuests
                                    AND price >= :minPrice AND price <= :maxPrice 
                                    AND room_id  NOT IN(
                                    SELECT room_id FROM booking
                                    WHERE check_in_date <= :checkOutDate AND check_out_date >= :checkInDate)', $parameters);
   
    }

    //Get room by room_id
    public function get($roomId){
        $parameters = [
            ':roomId' => $roomId,
        ];
        return $this->fetch('SELECT room.*, room_type.title AS room_type FROM room
                            INNER JOIN room_type ON room.type_id = room_type.type_id 
                            WHERE room_id = :roomId', $parameters);
    }
}