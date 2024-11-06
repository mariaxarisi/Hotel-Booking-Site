<?php 
require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;

$room = new Room();

//Get page parametres
$selectedCity = $_GET['city'];
$selectedRoomType = $_GET['room_type'];
$checkIn = $_GET['check-in'];
$checkOut = $_GET['check-out'];

$availableRooms = $room->searchRoom($selectedCity, $selectedRoomType, new DateTime($checkIn), new DateTime($checkOut));

//Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

//Get cities
$cities = $room->getCities();
?>
<!DOCTYPE html>

<html>
<head>
    <title>Hotels</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/list.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
    <script src="assets/js/list.js"></script>
    <script src="assets/pages/search.js"></script>
</head>
<body>
    <header>
        <div class="container">
            <p>Hotels</p>
            <div>
                <p>
                    <a href="index.php">
                        <i class="fa-solid fa-house"></i>Home
                    </a>
                </p>
                <p>
                    <a href="profile.php">
                        <i class="fa-solid fa-user"></i>Profile
                    </a>
                </p>
            </div>
        </div>
        <div class="gradient"></div>
    </header>
    <main>
        <form name="searchForm" action="list.php" class="searchForm">
            <div class="shadow"></div>
            <div class="form">
                <p>Find the perfect hotel</p>

                <select name="count_of_guests" id="count_of_guests">
                    <option value="none" selected>Count of Guests</option>
                    <?php
                    foreach($allTypes as $roomType){
                    ?>
                    <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['type_id']; ?></option>
                    <?php } ?>
                </select>

                <select name="room_type" id="room_type">
                    <option value="none">Room Type</option>
                    <?php 
                    foreach($allTypes as $roomType){
                    ?>
                        <option <?php echo $selectedRoomType == $roomType['type_id'] ? 'selected' : ''; ?> value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                    <?php } ?>
                </select>

                <select name="city" id="city" required>
                    <option value="none">City</option>
                    <?php 
                    foreach($cities as $city){
                    ?>
                        <option <?php echo $selectedCity == $city ? 'selected' : ''; ?> value="<?php echo $city; ?>"><?php echo $city; ?></option>
                    <?php } ?>
                </select>

                <div class="range">
                    <div id="rangeMin">0&euro;</div>
                    <div id="rangeMax">5000&euro;</div>
                </div>
                <div class="slider">
                    <input type="range" min="0" max="5000" name="minPrice" value="00" id="slider1">
                    <input type="range" min="0" max="5000" name="maxPrice" value="5000" id="slider2">
                </div>

                <input type="text" name="check-in" id="check-in" placeholder="Check-in Date" value="<?php echo $checkIn; ?>">
                <input type="text" name="check-out" id="check-out" placeholder="Check-out Date" value="<?php echo $checkOut; ?>">
                
                <input type="submit" id="submit" class="active" value="FIND HOTEL">
            </div>
        </form>
        <div class="results">
            <p>Search Results</p>
            <?php
            foreach($availableRooms as $room){
            ?>
            <section class="hotel">
                <div class="hotel_up">
                    <img src="assets/images/rooms/<?php echo $room['photo_url']; ?>">
                    <div class="hotel_descr">
                        <p><?php echo $room['name']; ?></p>
                        <p><?php echo $room['city']; ?>, <?php echo $room['area']; ?></p>
                        <p><?php echo $room['description_short']; ?></p>
                        <button><a href="room.php?room_id=<?php echo $room['room_id']; ?>&check_in_date=<?php echo $checkIn; ?>&check_out_date=<?php echo $checkOut; ?>">
                                Go to Room Page</a>
                        </button>
                    </div>
                </div>
                <div class="hotel_down">
                    <div class="price">
                        Per Night: <?php echo $room['price']; ?>&euro;
                    </div>
                    <div class="container">
                        <div class="guests">Count of Guests: <?php echo $room['count_of_guests']; ?></div>
                        <div class="type">Type of Room: <?php echo $allTypes[$room['type_id']-1]['title']; ?></div>
                    </div>
                </div>
            </section>
            <?php } ?>

            <?php
            if(count($availableRooms) == 0){
            ?>
            <h2 class="no-rooms">There are no rooms!</h2>
            <?php } ?>
        </div>
    </main>
    <footer>
        <p>&copy; colleglink 2024</p>
    </footer>
</body>

</html>