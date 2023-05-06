<?php

// connecting to our database
$link = mysqli_connect("localhost", "root", "", "rentacar");
// Check connection, if false we stop the proccess and print the error message
if($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Retrieving cars that are available at that location and between the selected dates by the user
if (isset($location) && isset($start_date) && isset($end_date)) {
  $sql = "SELECT v.* FROM vehicles v
  LEFT JOIN bookings b ON v.vehicle_id = b.vehicle_id
  WHERE v.location = '$location' AND (b.booking_id IS NULL OR b.end_date < '$start_date' OR b.start_date > '$end_date')";
}
// if user didn't fill the search fields, retrieve all the cars
else {
  $sql = "SELECT * FROM vehicles";
}

if($result = mysqli_query($link, $sql)) {
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $id = $row['vehicle_id'];
            $name = $row['brand'].' '.$row['model'];
            $year = $row['year'];
            $image_url = $row['image_url'];
            $price = $row['price_per_day'];
            $type = $row['type'];
            $engine = $row['engine'];
            $transmission = $row['transmission'];
            $location = $row['location'];

            // calling our function with needed parameters that renders our data in HTML
            carRender($id, $name, $year, $image_url, $price, $type, $engine, $transmission, $location);
        }
    } else {
        echo "No cars are available at that location and the dates you selected.";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
// Close connection
mysqli_close($link);

// including our JS script
echo '<script src="./assets/js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>';


function carRender($id, $car_name, $year, $image_url, $price, $type, $engine, $transmission, $location)
{
    echo '<li>
        <div class="featured-car-card">

          <figure class="card-banner">
            <img src="'.$image_url.'" alt="'.$car_name.'" loading="lazy" width="440" height="300" class="w-100">
          </figure>

          <div class="card-content">

            <div class="card-title-wrapper">
              <h3 class="h3 card-title">
                <a href="#">'.$car_name.'</a>
              </h3>

              <data class="year" value="'.$year.'">'.$year.'</data>
            </div>

            <ul class="card-list">

              <li class="card-list-item">
                <ion-icon name="people-outline"></ion-icon>

                <span class="card-item-text">'.$type.'</span>
              </li>

              <li class="card-list-item">
                <ion-icon name="flash-outline"></ion-icon>

                <span class="card-item-text">'.$engine.'</span>
              </li>

              <li class="card-list-item">
                <ion-icon name="location-outline"></ion-icon>

                <span class="card-item-text">'.$location.'</span>
              </li>

              <li class="card-list-item">
                <ion-icon name="hardware-chip-outline"></ion-icon>

                <span class="card-item-text">'.$transmission.'</span>
              </li>

            </ul>

            <div class="card-price-wrapper">

              <p class="card-price">
                <strong>'.$price.'</strong> / day
              </p>

              <button class="btn" onClick="addToBookings('.$id.','.$price.')">Rent now</button>

            </div>

          </div>

        </div>
      </li>';
}
?>