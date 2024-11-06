<?php 
require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;

$room = new Room();

//Get cities
$cities = $room->getCities();

//Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();
?>
<!DOCTYPE html>

<html>

<head>
    <title>Home</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
    <script src="assets/js/index.js"></script>
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
    </header>
    <main>
        <form action="list.php" method="get">

            <select name="city" id="city" required>
                <option value="none" selected>City</option>
                <?php 
                foreach($cities as $city){
                ?>
                    <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                <?php } ?>
            </select>

            <select name="room_type" id="room_type">
                <option value=0 selected>Room Type</option>
                <?php 
                foreach($allTypes as $roomType){
                ?>
                    <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                <?php } ?>
            </select>

            <input type="text" name="check-in" id="datepicker1" placeholder="Check-in Date">

            <input type="text" name="check-out" id="datepicker2" placeholder="Check-out Date">

            <input type="submit" value="Search" id="submit" class="disabled" disabled>
        </form>
    </main>
    <footer>
        <p>&copy; colleglink 2024</p>
    </footer>
</body>

</html>