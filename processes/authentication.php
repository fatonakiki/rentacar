<?php
// starting the session
session_start();

// connecting to our database
$link = mysqli_connect("localhost", "root", "", "rentacar");
    // Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// only going further if username and password are provided
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    
    $sql = "SELECT * FROM users where username ='$username'";

    // Attempting execution of query
    $result = mysqli_query($link, $sql);

    // if the number of rows is bigger than 0 it means there is data se we continue with what we want to do with that data
    if(mysqli_num_rows($result) > 0){
        // we store the result as an associative array
        $row = mysqli_fetch_assoc($result);
        // we store the password, role and user_id we got from the database 
        $hashedPassword = $row["password"];
        $role = $row["role"];
        $user_id = $row["user_id"];

        // we verify if the passwords match by using a php built-in function called password_verify that verifies if a password matches a hash
        if (password_verify($password, $hashedPassword)) {
            // Password matches, login successful, store user info in the session
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            // if the role of the user is staff redirect to admin panel
            if ($role == 'staff') {
                header("Location: ../admin.php");
                die();
            }
            // otherwise redirect to user panel
            else {
                header("Location: ../user.php");
                die();
            }
            
        } else {
            // Invalid password
            echo '<script type="text/javascript">'; 
            echo 'alert("Invalid Password!");'; 
            echo 'window.location.href = "../register.php";';
            echo '</script>';
        }
    }
    else {
        // User doesn't exist
        echo '<script type="text/javascript">'; 
        echo 'alert("User does not exist!");'; 
        echo 'window.location.href = "../register.php";';
        echo '</script>';
    }
}

?>




