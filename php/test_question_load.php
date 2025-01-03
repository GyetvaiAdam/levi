<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();

}

$conn = mysqli_connect("localhost", "root", "", "16szemelyiseg");

$sql = "SELECT `question_text` FROM `kerdesek`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$array = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row['question_text'];
    }
}

if (!empty($array)) {
    echo json_encode($array);
} else {
    echo json_encode([]);
}

mysqli_close($conn);
?>
