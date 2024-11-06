<?php 
require __DIR__.'/../boot/boot.php';

use Hotel\User;

if(!empty(User::getCurrentUserId())){
    header('Location: /project/public/index.php');die;
}
?>
<!DOCTYPE html>

<html>

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <script src="assets/js/register.js"></script>
</head>

<body>
    <header>
        <div class="container">
            <p>Hotels</p>
            <p>
                <a href="index.php">
                    <i class="fa-solid fa-house"></i>Home
                </a>
            </p>
        </div>
        <div class="gradient"></div>
    </header>
    <main>
        <div class="form">
            <form action="actions/register.php" method="post">
                <?php if(!empty($_GET['error'])){ ?>
                <div class="error">Register Error</div>
                <?php } ?>
                <div class="row">
                    <label for="name">Username</label>
                    <input type="text" name="name" id="name" placeholder="Your username">
                </div>

                <div class="row">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Your email address">
                </div>
                <div class="error email-error">This is not a valid email.</div>

                <div class="row">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Your password">
                </div>
                <div class="error password-error">The password should have at least five characters</div>

                <div class="row">
                    <label for="password_repeat">Repeat Password</label>
                    <input type="password" name="password_repeat" id="password_repeat" placeholder="Repeat your password">
                </div>
                <div class="error passRepeat-error">You should enter the same password</div>

                <input type="submit" value="REGISTER">
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; colleglink 2024</p>
    </footer>
</body>

</html>