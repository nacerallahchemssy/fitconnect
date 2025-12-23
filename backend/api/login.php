<?php
include "../config/db.php";
include "../headers.php";

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password)) {
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$email = htmlspecialchars(strip_tags($data->email));
$password = $data->password;

$sql = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email=?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        unset($user['password']); // نحيدو password من الرد
        echo json_encode([
            "success" => true,
            "user" => $user
        ]);
    } else {
        echo json_encode(["error" => "Wrong password"]);
    }
} else {
    echo json_encode(["error" => "User not found"]);
}
?>
