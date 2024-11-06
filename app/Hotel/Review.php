<?php

namespace Hotel;

use Hotel\BaseService;

class Review extends BaseService{
    
    //Get reviews by room_id
    public function getReviews($roomId){
        $parameters = [
            ':roomId' => $roomId,
        ];
        return $this->fetchAll('SELECT review.*, user.name as user_name 
                                FROM review INNER JOIN user ON review.user_id = user.user_id 
                                WHERE room_id = :roomId
                                ORDER BY created_time ASC', $parameters);
    }

    //Get reviews by user_id
    public function getReviewsByUser($userId){
        $parameters = [
            ':userId' => $userId,
        ];
        return $this->fetchAll('SELECT review.*, room.name 
                                FROM review INNER JOIN room ON review.room_id = room.room_id 
                                WHERE user_id = :userId
                                ORDER BY created_time ASC', $parameters);
    }
    
    //Add a review
    public function addReview($roomId, $userId, $review, $rate){

        //Star transaction
        $this->getPDO()->beginTransaction();

        $parameters = [
            ':roomId' => $roomId,
            ':userId' => $userId,
            ':review' => $review,
            ':rate' => $rate
        ];

        $this->execute('INSERT INTO review (room_id, user_id, comment, rate) 
                         VALUES (:roomId, :userId, :review, :rate)', $parameters);

        //Update room avreage reviews
        $parameters = [
            ':roomId' => $roomId,
        ];
        $roomAvg = $this->fetch('SELECT avg(rate) as avg_reviews, count(*) as count 
                                FROM review WHERE room_id = :roomId', $parameters);

        $parameters = [
            ':avg_reviews' => $roomAvg['avg_reviews'],
            ':count' => $roomAvg['count'],
            ':roomId' => $roomId
        ];
        $this->execute('UPDATE room SET avg_reviews = :avg_reviews, count_reviews = :count 
                        WHERE room_id = :roomId', $parameters);

        //Commit transaction
        return $this->getPDO()->commit();
    }
}

?>