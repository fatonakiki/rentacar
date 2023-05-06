<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form {
            max-width: 600px;
            margin: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form id="formAdd" method="POST" action="" enctype="multipart/form-data">

        <input type="hidden" name="vehicle_id">
        <label for="start_date">Pick-up Date:</label>
        <input type="date" name="start_date" required>

        <label for="end_date">Return Date:</label>
        <input type="date" name="end_date" required>

        <label for="price">Price:</label>
        <input type="decimal" name="price" required>


        <input type="submit" value="Submit">
    </form>


    <?php
    if(!isset($_SESSION['username'])) {
        header("Location: ./register.php");
        die();
    }
    if (isset($_POST["vehicle_id"]) && isset($_POST["start_date"]) && isset($_POST["end_date"])) {
        $vehicle_id = $_POST["vehicle_id"];
        $start_date=$_POST["start_date"];
        $end_date=$_POST["end_date"];
        $price = $_POST["price"];
                /* Attempt MySQL server connection. Assuming you are running MySQL
        server with default setting (user 'root' with no password) */
        $link = mysqli_connect("localhost", "root", "", "rentacar");
        // Check connection
        if($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $user_id = $_SESSION["user_id"];
        $sql = "INSERT INTO bookings(user_id, vehicle_id, start_date, end_date, total_price) VALUES($user_id, $vehicle_id, '$start_date', '$end_date', $price)";

        if(mysqli_query($link, $sql)) {
         //   echo "Records inserted successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        // Close connection
        mysqli_close($link);
    }
    ?>

</body>
</html>