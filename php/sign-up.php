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

    if (empty($data["email"]) || empty($data["password"])) {
        echo json_encode([
            "status" => "error",
            "message" => "Email or password cannot be empty.",
        ]);
        http_response_code(400);
        exit();
    }

    $conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");
    $email = $data["email"];
    $password = password_hash($data["password"], PASSWORD_BCRYPT);
    $sql = "INSERT INTO `felhasznalok_adatai`(`user_email`, `user_password`) VALUES ('$email','$password')";
    mysqli_query($conn, $sql);
    echo json_encode([
        "status" => "success",
        "message" => "Data received successfully.",
        "email" => $email,
    ]);

    mysqli_close($conn);
?>