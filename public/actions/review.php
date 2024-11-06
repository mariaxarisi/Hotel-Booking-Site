<?php

require_once __DIR__.'/../../boot/boot.php';
use Hotel\User;
use Hotel\Review;

//Return to home page if not a post request
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /project/public/index.php');
    return;
}

//Return to home page if there is a logged in user
if(empty(User::getCurrentUserId())){
    header('Location: /project/public/index.php');
    return;
}

//Check if room id is given 
$roomId = $_REQUEST['room_id'];
if(empty($roomId)){
    header('Location: /project/public/index.php');
    return;
}

//Add review
$review = new Review(); 
$review->addReview($roomId, User::getCurrentUserId(), $_REQUEST['review'], $_REQUEST['starCount']);

//Return to room page
$checkIn = $_REQUEST['check_in_date'];
$checkOut = $_REQUEST['check_out_date'];
header(sprintf('Location: /project/public/room.php?room_id=%s&check_in_date=%s&check_out_date=%s', $roomId, $checkIn, $checkOut));

?>