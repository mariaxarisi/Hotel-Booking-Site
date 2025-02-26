<?php

require_once __DIR__.'/../../boot/boot.php';
use Hotel\User;

//Return to home page if not a post request
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /index.php');
    return;
}

//Return to home page if there is a logged in user
if(!empty(User::getCurrentUserId())){
    header('Location: /index.php');
    return;
}

$user = new User();
try{
    if(!$user->verify($_REQUEST['email'], $_REQUEST['password'])){
        header('Location: /public/login.php?error=Could not verify user');
        return;
    }
} 
catch(InvalidArgumentException $ex) {
    header('Location: /public/login.php?error=No user exist with the given email');
    return;
}

//Retrieve user
$userInfo = $user->getByEmail($_REQUEST['email']);

//Generate Token
$token = $user->generateToken($userInfo['user_id']);

//Set cookie
setcookie('user_token', $token, time()+(30*24*60*60), '/');

//Return to home page
header('Location: /index.php');
?>