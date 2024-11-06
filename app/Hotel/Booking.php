<?php

namespace Hotel;
use DateTime;
use Hotel\BaseService;

class Booking extends BaseService{

    public function isBooked($roomId, $fromDate, $toDate){

        // Convert date formats from MM/DD/YYYY to YYYY-MM-DD
        $fromDate = DateTime::createFromFormat('m/d/Y', $fromDate)->format('Y-m-d');
        $toDate = DateTime::createFromFormat('m/d/Y', $toDate)->format('Y-m-d');

        $parameters = [
            'room_id' => $roomId,
            'from_date' => $fromDate,
            'to_date' => $toDate
        ];

        $rows = $this->fetchAll('SELECT room_id FROM booking WHERE room_id = :room_id 
                                AND check_in_date <= :to_date AND check_out_date >= :from_date', $parameters);

        return count($rows) > 0;
    }

    public function addBooking($roomId, $userId, $fromDate, $toDate){

        //Start transaction
        $this->getPDO()->beginTransaction();

        //Get room info
        $parameters = ['room_id' => $roomId];
        $room = $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
        $price = $room['price'];

        //Calculate total price
        $checkIn = new DateTime($fromDate);
        $checkOut = new DateTime($toDate);
        $days = $checkIn->diff($checkOut)->days;
        $totalPrice = $price * $days;

        // Convert date formats from MM/DD/YYYY to YYYY-MM-DD
        $fromDate = DateTime::createFromFormat('m/d/Y', $fromDate)->format('Y-m-d');
        $toDate = DateTime::createFromFormat('m/d/Y', $toDate)->format('Y-m-d');

        $parameters = [
            'room_id' => $roomId,
            'user_id' => $userId,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'total_price' => $totalPrice
        ];

        $this->execute('INSERT INTO booking (room_id, user_id, total_price, check_in_date, check_out_date) 
                        VALUES (:room_id, :user_id, :total_price, :from_date, :to_date)', $parameters);

        //Commit transaction
        return $this->getPDO()->commit();
    }

    public function getBookings($userId){

        $parameters = ['user_id' => $userId];
        return $this->fetchAll('SELECT booking.*, room.name , room.photo_url, room.city, room.area,
                                room.description_short, room_type.title AS room_type
                                FROM booking 
                                INNER JOIN room ON booking.room_id = room.room_id
                                INNER JOIN room_type ON room.type_id = room_type.type_id
                                WHERE user_id = :user_id', $parameters);
    }
}

?>