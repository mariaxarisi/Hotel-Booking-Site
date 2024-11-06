<?php 
require __DIR__.'/../../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;

$room = new Room();

//Get page parametres
$selectedCity = $_GET['city'];
$selectedRoomType = $_GET['room_type'];
$checkIn = $_GET['check-in'];
$checkOut = $_GET['check-out'];
$countOfGuests = $_GET['count_of_guests'];
$minPrice = $_GET['minPrice'];
$maxPrice = $_GET['maxPrice'];

$availableRooms = $room->searchRoomExtended($selectedCity, $selectedRoomType, new DateTime($checkIn), new DateTime($checkOut), $countOfGuests, $minPrice, $maxPrice);

//Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

?>

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