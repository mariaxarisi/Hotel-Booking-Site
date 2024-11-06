<?php

error_reporting(E_ERROR);

// Register autoload function
spl_autoload_register(function ($class) {
	$class = str_replace("\\", "/", $class);
    require_once sprintf(__DIR__.'/../app/%s.php', $class);
});

use Hotel\User;

$user = new User();

// Check if there is a token in the request
if (isset($_COOKIE['user_token'])) {
    $userToken = $_COOKIE['user_token'];
    
    // Verify user
    if ($user->verifyToken($userToken)) {
        // Set user in memory
        $userInfo = $user->getTokenPayload($userToken);
        User::setCurrentUserId($userInfo['user_id']);
    }
}
?>