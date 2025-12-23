<?php
include "../config/db.php";
include "../headers.php";

$data = json_decode(file_get_contents("php://input"));

if (
    !isset($data->name) ||
    !isset($data->email) ||
    !isset($data->password)
) {
    echo json_encode(["error" => "Missing fields"]);
    exit;
}

$name = htmlspecialchars(strip_tags($data->name));
$email = htmlspecialchars(strip_tags($data->email));
$password = password_hash($data->password, PASSWORD_BCRYPT);

// check email exists
$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["error" => "Email already exists"]);
    exit;
}

$sql = $conn->prepare(
    "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
);
$sql->bind_param("sss", $name, $email, $password);

if ($sql->execute()) {
    echo json_encode(["success" => "User registered"]);
} else {
    echo json_encode(["error" => "Registration failed"]);
}
?>
