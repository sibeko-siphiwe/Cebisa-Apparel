<?php

$host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "cebisa_apparel";

// Create a PDO instance
$dsn = "mysql:host=$host;dbname=$db_name";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $db_username, $db_password, $options);

// Get the posted values
$username = filter_var($_POST["Username"], FILTER_UNSAFE_RAW);
$mobileNumber = filter_var($_POST["Mobile_Numbers"], FILTER_VALIDATE_INT);
$password = filter_var($_POST["Password"], FILTER_UNSAFE_RAW);

// Validate inputs
$username = trim($_POST["Username"]);
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    throw new Exception('Invalid username');
}

$mobileNumber = trim($_POST["Mobile_Numbers"]);
if (!preg_match('/^[0-9]+$/', $mobileNumber)) {
    throw new Exception('Invalid mobile number');
}

$password = trim($_POST["Password"]);
if (strlen($password) < 8) {
    throw new Exception('Password must be at least 8 characters long');
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare the query
$stmt = $pdo->prepare("INSERT INTO Users (Username, Mobile_number, Password) VALUES (:username, :mobile_number, :password)");
$stmt->bindParam(":username", $username);
$stmt->bindParam(":mobile_number", $mobileNumber);
$stmt->bindParam(":password", $hashedPassword);
$stmt->execute();

// Now you can use the same PDO instance to execute other queries
$query = 'SELECT * FROM Users WHERE Username = :username';
$params = [':username' => $username];
$stmt = executePreparedStatement($pdo, $query, $params);
$user = $stmt->fetch();

$pdo = null;

if ($user) {
    header('Location: home.html'); // assuming your home page is named home.php
    exit;
}

function executePreparedStatement($pdo, $query, $params) {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

?>