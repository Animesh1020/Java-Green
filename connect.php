<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $userPassword = $_POST["password"];

    // Validate and sanitize the form data
    $fullName = filter_var($fullName, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $userPassword = filter_var($userPassword, FILTER_SANITIZE_STRING);

    // Hash the password
    $passwordHash = password_hash($userPassword, PASSWORD_DEFAULT);

    // Create a connection to MySQL
    $servername = "localhost";
    $username = ""; // Enter your MySQL username
    $dbpassword = "root"; // Enter your MySQL password
    $database = "register"; // Enter your MySQL database name

    $conn = new mysqli($servername, $username, $dbpassword, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the form data into a database table
    $sql = "INSERT INTO users (fullName, email, password) VALUES ('$fullName', '$email', '$passwordHash')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
