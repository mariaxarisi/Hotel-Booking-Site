<?php
require __DIR__.'/../boot/boot.php';

use Hotel\Review;
use Hotel\Booking;
use Hotel\Favorite;
use Hotel\User;

$review = new Review();
$booking = new Booking();
$favorite = new Favorite();

$userId = User::getCurrentUserId();
if(empty($userId)){
    header('Location: /public/login.php');
}

//Get all favorites
$favorites = $favorite->getFavorites($userId);

//Get all reviews
$reviews = $review->getReviewsByUser($userId);

//Get all user bookings
$bookings = $booking->getBookings($userId);

?>
<!DOCTYPE html>

<html>
<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
</head>
<body>
    <header>
        <div class="container">
            <p>Hotels</p>
            <div>
                <p>
                    <a href="../index.php">
                        <i class="fa-solid fa-house"></i>Home
                    </a>
                </p>
                <p>
                    <a href="actions/logout.php">
                        <i class="fa-solid fa-sign-out"></i>LogOut
                    </a>
                </p>
            </div>
        </div>
        <div class="gradient"></div>
    </header>
    <main>
        <div class="favorites">
            <div class="shadow"></div>
            <div class="container">
                <p>favorites</p>
                <ol>
                <?php if(count($favorites)){ ?>
                    <?php foreach($favorites as $favorite){ ?>
                        <li>
                            <a class="hoverColor" href="room.php?room_id=<?php echo $favorite['room_id']; ?>"><?php echo $favorite['name']; ?></a>
                        </li>
                    <?php } ?> 
                <?php } else{ ?>
                    <p class="noFavorites">No favorites found</p>
                <?php } ?>
                </ol>
                <p>reviews</p>
                <ol>
                    <?php if(count($reviews)){ ?>
                    <?php foreach($reviews as $review){ ?>
                        <li>
                            <a class="hoverColor" href="room.php?room_id=<?php echo $review['room_id']; ?>"><?php echo $review['name']; ?></a><br>
                            <?php for($i=1; $i<=5; $i++){
                                if($i <= $review['rate']){ ?>
                                    <i class="fa-solid fa-star yellow-star"></i>
                                <?php } else{ ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php } ?>
                            <?php } ?>
                        </li>
                    <?php } ?> 
                    <?php } else{ ?>
                        <p class="noReviews">No reviews found</p>
                    <?php } ?>
                </ol>
            </div>
        </div>
        <div class="results">
            <p>My Bookings</p>
            <?php if(count($bookings)){
                    foreach($bookings as $booking){ ?>
                        <section class="hotel">
                            <div class="hotel_up">
                                <img src="assets/images/rooms/<?php echo $booking['photo_url']; ?>">
                                <div class="hotel_descr">
                                    <p><?php echo $booking['name']; ?></p>
                                    <p><?php echo $booking['city']; ?>, <?php echo $booking['area']; ?></p>
                                    <p><?php echo $booking['description_short']; ?></p>
                                    <button><a href="room.php?room_id=<?php echo $booking['room_id']; ?>">Go to Room Page</a></button>
                                </div>
                            </div>
                            <div class="hotel_down">
                                <div class="price">
                                    Total Cost: <?php echo $booking['total_price']; ?>&euro;
                                </div>
                                <div class="container">
                                    <div class="check-in">Check-In Date: <?php echo $booking['check_in_date']; ?></div>
                                    <div class="check_out">Check-Out Date: <?php echo $booking['check_out_date']; ?></div>
                                    <div class="type">Type of Room: <?php echo $booking['room_type']; ?></div>
                                </div>
                            </div>
                        </section>
            <?php } } else{ ?>
                <h3 class="noBookings">No bookings found!</h3>
            <?php } ?>
        </div>
    </main>
    <footer>
        <p>&copy; colleglink 2024</p>
    </footer>
</body>
</html>