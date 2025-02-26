<?php

require_once __DIR__.'/../../boot/boot.php';
use Hotel\User;
use Hotel\Booking;

//Return to home page if not a post request
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /index.php');
    return;
}

//Return to home page if there is a logged in user
if(empty(User::getCurrentUserId())){
    header('Location: /public/login.php');
    return;
}

//Check if room id is given 
$roomId = $_REQUEST['room_id'];
if(empty($roomId)){
    header('Location: /index.php');
    return;
}

$csrf = $_REQUEST['csrf'];
if(empty($csrf) || !User::verifyCSRF($csrf)){
    header('Location: /index.php');
    return;
}

//Create booking
$booking = new Booking();
$checkIn = $_REQUEST['check_in_date'];
$checkOut = $_REQUEST['check_out_date'];
$booking->addBooking($roomId, User::getCurrentUserId(), $checkIn, $checkOut);

//Return to room page
$checkIn = $_REQUEST['check_in_date'];
$checkOut = $_REQUEST['check_out_date'];
header(sprintf('Location: /public/room.php?room_id=%s&check_in_date=%s&check_out_date=%s', $roomId, $checkIn, $checkOut));
?>