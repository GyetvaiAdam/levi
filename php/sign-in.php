<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    $conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");
    $email = $data["email"];
    $password = $data["password"];

    $sql = "SELECT `user_password` FROM `felhasznalok_adatai` WHERE `user_email` = '$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['user_password'])) {
        echo json_encode([
            "status" => "success",
            "message" => "Login successful.",
            "email" => $email,
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid email or password.",
        ]);
    }
    mysqli_close($conn);
?>