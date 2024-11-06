<?php

namespace Hotel;

use Hotel\BaseService;

class Favorite extends BaseService{

    public function isFavorite($roomId, $userId){
        $parameters = [
            ':roomId' => $roomId,
            ':userId' => $userId
        ];
        
        $rows = $this->fetch('SELECT * FROM favorite WHERE room_id = :roomId AND user_id = :userId', $parameters);

        return !empty($rows);
    }

    public function addFavorite($roomId, $userId){
        //Check if favorite already exists
        if($this->isFavorite($roomId, $userId)){
            return true;
        }

        //Prepare parametres
        $parameters = [
            ':roomId' => $roomId,
            ':userId'=> $userId
        ];

        $rows = $this->execute('INSERT INTO favorite(room_id, user_id) VALUES (:roomId, :userId)', $parameters);

        return $rows == 1;
    }

    public function removeFavorite($roomId, $userId){
        //Prepare parametres
        $parameters = [
            ':roomId' => $roomId,
            ':userId'=> $userId
        ];

        $rows = $this->execute('DELETE FROM favorite WHERE room_id = :roomId AND user_id = :userId', $parameters);

        return $rows == 1;
    }

    public function getFavorites($userId){
        $parameters = [
            ':userId' => $userId
        ];

        return $this->fetchAll('SELECT favorite.*, room.name FROM favorite
                                INNER JOIN room ON favorite.room_id = room.room_id
                                WHERE user_id = :userId', $parameters);
    }
}