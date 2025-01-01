<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();

}

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");
$question_id = $data["question_id"];

$sql = "SELECT `question_text` FROM `kerdesek` WHERE `question_id` = '$question_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if($row){

    echo json_encode($data);
}else{
    echo json_encode(["message" => "No records found"]);
}

mysqli_close($conn);
?>