<?php
header('Content-Type: application/json');


$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$data = json_decode(file_get_contents('php://input'), true);
$email = $conn->real_escape_string($data['email']);
$password = $conn->real_escape_string($data['password']);


$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode("Email already registered.");
} else {
    
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode("Registration successful.");
    } else {
        echo json_encode("Error: " . $sql . "<br>" . $conn->error);
    }
}


$conn->close();
?>
