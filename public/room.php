<?php 
require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;

$room = new Room();
$favorite = new Favorite();

//Check for room id
$roomId = $_REQUEST['room_id'];
if(empty($roomId)){
    header('Location: index.php');
    die;
}

//Load room info
$roomInfo = $room->get($roomId);
if(empty($roomInfo)){
    header('Location: index.php');
    die;
}

//Get current user id
$userId = User::getCurrentUserId();

//Check if room is favorite
$isFavorite = $favorite->isFavorite($roomId, $userId);

//Load reviews
$review = new Review();
$reviews = $review->getReviews($roomId);

//Get check in and check out dates
$checkIn = $_REQUEST['check_in_date'];
$checkOut = $_REQUEST['check_out_date'];

//Check if room is already booked
$alreadyBooked = empty($checkIn) || empty($checkOut);
if(!$alreadyBooked){
    $booking = new Booking();
    $alreadyBooked = $booking->isBooked($roomId, $checkIn, $checkOut);
}

?>
<!DOCTYPE html>

<html>

<head>
    <title>Room</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/room.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <script src="assets/js/room.js"></script>
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
        <div class="header">
            <div class="info">
                <?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']); ?>
                | Reviews: 
                <?php
                    $roomAvgReview = $roomInfo['avg_reviews'];
                    for($i = 1; $i <= 5; $i++){
                        if($roomAvgReview >= $i){
                            ?>
                                <i class="fa-solid fa-star checked"></i>
                            <?php
                        } else {
                            ?>
                                <i class="fa-solid fa-star"></i>
                            <?php
                        }
                    }
                ?> | 
            
                <form name="favoriteForm" id="favoriteForm" class="favoriteForm" method="post" action="actions/favorite.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                    <input type="hidden" name="csrf" value="<?php echo User::getCSRF(); ?>">
                    <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                    <input type="hidden" name="check_in_date" value="<?php echo $checkIn; ?>">
                    <input type="hidden" name="check_out_date" value="<?php echo $checkOut; ?>">
                    <button type="button" style="margin: 0; padding: 0;" onclick="document.getElementById('favoriteForm').submit();">
                        <i class="fa-solid fa-heart <?php echo $isFavorite ? 'selected' : '';?>"></i>
                    </button>
                </form>
            </div>
            <div class="price">Per Night: <?php echo $roomInfo['price']; ?>&euro;</div>
        </div>
        <div class="image"><img src="assets/images/rooms/<?php echo $roomInfo['photo_url']; ?>"></div>
        <div class="extra-info">
            <div class="guests"><i class="fa-solid fa-user"></i><?php echo $roomInfo['count_of_guests']; ?><br>
                                COUNT OF GUESTS</div>
            <div class="type"><i class="fa-solid fa-bed"></i><?php echo $roomInfo['room_type']; ?><br>
                                TYPE OF ROOM</div>
            <div class="parking"><i class="fa-solid fa-car"></i><?php echo $roomInfo['parking'] ? "Yes" : "No"; ?><br>
                                PARKING</div>
            <div class="wifi"><i class="fa-solid fa-wifi"></i><?php echo $roomInfo['wifi'] ? "Yes" : "No"; ?><br>
                                WIFI</div>
            <div class="pet"><i class="fa-solid fa-dog"></i><?php echo $roomInfo['pet_friendly'] ? "Yes" : "No"; ?><br>
                            PET FRIENDLY</div>
        </div>
        <div class="descr">
            <p>Room Description</p>
            <p><?php echo $roomInfo['description_long']; ?></p>
        </div>
        <?php
            if($alreadyBooked){
        ?>
                <div class="button"><button>Already Booked</button></div>
        <?php  } else { ?>
            <form name="bookingForm" method="post" action="actions/book.php">
                <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                <input type="hidden" name="csrf" value="<?php echo User::getCSRF(); ?>">
                <input type="hidden" name="check_in_date" value="<?php echo $checkIn; ?>">
                <input type="hidden" name="check_out_date" value="<?php echo $checkOut; ?>">
                <div class="button"><button>Book Now</button></div>
            </form>
        <?php } ?>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3145.0405833807313!2d23.732737374278326!3d37.976182200535206!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bd4b45322381%3A0xb126665c4705d54b!2sHotel%20Grande%20Bretagne%2C%20a%20Luxury%20Collection%20Hotel%2C%20Athens!5e0!3m2!1sel!2sgr!4v1711826857279!5m2!1sel!2sgr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <div class="line"></div>
        <div class="reviews">
            <p>Reviews</p>
            <ol>
                <?php
                    foreach($reviews as $review){
                        ?>
                            <li>
                                <?php echo $review['user_name']; ?>
                                <?php
                                    for($i = 1; $i <= 5; $i++){
                                        if($review['rate'] >= $i){
                                            ?>
                                                <i class="fa-solid fa-star yellow-star"></i>
                                            <?php
                                        } else {
                                            ?>
                                                <i class="fa-solid fa-star"></i>
                                            <?php
                                        }
                                    }
                                ?>
                                <div><?php echo htmlentities($review['comment']); ?></div>
                                <div class="time">Add time: <?php echo $review['created_time']; ?></div>
                            </li>
                        <?php
                    }
                ?>
            </ol>
        </div>
        <div class="add-review">
            <p>Add Review</p>
            <form name="reviewForm" method="post" action="actions/review.php">
                <div class="stars"><i id="star1" class="fa-solid fa-star"></i>
                    <i id="star2" class="fa-solid fa-star"></i>
                    <i id="star3" class="fa-solid fa-star"></i>
                    <i id="star4" class="fa-solid fa-star"></i>
                    <i id="star5" class="fa-solid fa-star"></i></div>

                <textarea id="review" name="review" placeholder="Review"></textarea>
                <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                <input type="hidden" name="csrf" value="<?php echo User::getCSRF(); ?>">
                <input type="hidden" id="starCount" name="starCount" value="0">
                <input type="hidden" name="check_in_date" value="<?php echo $checkIn; ?>">
                <input type="hidden" name="check_out_date" value="<?php echo $checkOut; ?>">

                <input type="submit" id="submit" class="disabled" disabled>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; colleglink 2024</p>
    </footer>
</body>

</html>