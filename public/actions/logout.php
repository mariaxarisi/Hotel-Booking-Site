<?php
require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;

//Return to home page if there is not a logged in user
if(empty(User::getCurrentUserId())){
    header('Location: /project/public/index.php');
    return;
}

// Delete user_token cookie
if (isset($_COOKIE['user_token'])) {
    unset($_COOKIE['user_token']);
    setcookie('user_token', '', time() - 3600, '/');
}

//Return to home page
header('Location: /project/public/index.php');

?>