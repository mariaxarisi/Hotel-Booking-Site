<?php

require_once __DIR__.'/../../boot/boot.php';
use Hotel\User;
use Hotel\Favorite;

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

//Add or remove room from favorites
$favorite = new Favorite();
$isFavorite = $_REQUEST['is_favorite'];

if(!$isFavorite){
    $favorite->addFavorite($roomId, User::getCurrentUserId());
}else {
    $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

//Return to room page
$checkIn = $_REQUEST['check_in_date'];
$checkOut = $_REQUEST['check_out_date'];
header(sprintf('Location: /project/public/room.php?room_id=%s&check_in_date=%s&check_out_date=%s', $roomId, $checkIn, $checkOut));
?>