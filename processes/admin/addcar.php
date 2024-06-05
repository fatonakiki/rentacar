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

        select,
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
    
        <input type="hidden" name="id" value="0" required>
        <div style="display: inline-block;">
        <label for="location">Location:</label>
        <select name="location">
            <option value="Peja">Peja</option>
            <option value="Prishtina">Prishtina</option>
            <option value="Prizren">Prizren</option>
            <option value="Ferizaj">Ferizaj</option>
            <option value="Gjakova">Gjakova</option>
            <option value="Mitrovica">Mitrovica</option>
        </select>

        <label for="type">Type:</label>
        <input type="text" name="type" required>

        </div>

        <div style="display: inline-block;">
        <label for="brand">Brand:</label>
        <input type="text" name="brand" required>

        <label for="model">Model:</label>
        <input type="text" name="model" required>

        </div>

        <div style="display: inline-block;">
        <label for="engine">Engine:</label>
        <input type="text" name="engine" required>

        <label for="transmission">Transmission:</label>
        <input type="text" name="transmission" required>
        </div>

        <div style="display: inline-block;">
        <label for="year">Year:</label>
        <input type="number" name="year" required>

        <label for="price">Price per day:</label>
        <input type="number" step="any" name="price" required>
        </div>

        <label for="image">Image:</label>
        <input type="file" name="image">

        <input type="submit" value="Submit">
    </form>


    <?php
    // only going through if location, type, brand, model, engine, transmission, year and price are submitted
    if (isset($_POST["location"]) && isset($_POST["type"]) && isset($_POST["brand"]) && isset($_POST["model"]) && isset($_POST["engine"]) && isset($_POST["transmission"]) && isset($_POST["year"]) && isset($_POST["price"])) {
        $location = $_POST["location"];
        $id = $_POST["id"];
        $type = $_POST["type"];
        $brand = $_POST["brand"];
        $model = $_POST["model"];
        $engine = $_POST["engine"];
        $transmission = $_POST["transmission"];
        $year = $_POST["year"];
        $price = $_POST["price"];
        $image = $_FILES['image'];
        $filename = $image['name'];
        $targetDir = 'uploads/';
        $imageUrl = '';
        // connecting to our database
        $link = mysqli_connect("localhost", "root", "", "rentacar");
        // Check connection
        if($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $file_type = $_FILES['image']['type']; //returns the mimetype

        $allowed = array("image/jpeg", "image/gif", "image/png");
        if(!in_array($file_type, $allowed)) {
            $error_message = 'Only jpg, gif, and png files are allowed.';

            echo "<meta http-equiv='refresh' content='0'><script>alert('$error_message')</script>";

            exit();

        }
        if (move_uploaded_file($image['tmp_name'], $targetDir . $filename)) {
            // Image uploaded successfully, save the URL in the database
            $imageUrl = $targetDir . $filename;
        }
        echo "<script>console.log('passed: $image_url')</script>";
        //if id is greater than 0 it means we are updating an existing row
        if ($id > 0) {
            if ($imageUrl == '') {
                $sql = "Update vehicles set location='$location', type='$type', brand='$brand', model='$model', engine='$engine', transmission='$transmission', year=$year, price_per_day=$price where vehicle_id=$id";
            } else {

                $sql = "Update vehicles set location='$location', type='$type', brand='$brand', model='$model', engine='$engine', transmission='$transmission', year=$year, price_per_day=$price, image_url='$imageUrl' where vehicle_id=$id";
            }
        }
        //otherwise we insert a new row
        else {
            $sql = "INSERT INTO vehicles(location, type, brand, model, engine, transmission, year, price_per_day, image_url) VALUES ('$location', '$type', '$brand', '$model', '$engine', '$transmission', $year, $price, '$imageUrl')";
        }

        // if query is executed successfully refresh the page
        if(mysqli_query($link, $sql)) {
            echo "<meta http-equiv='refresh' content='0'>";
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
