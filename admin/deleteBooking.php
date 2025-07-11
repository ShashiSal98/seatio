<?php 
// Check if 'id' is set and valid
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Error: Missing or invalid booking ID.");
}

$id = intval($_GET['id']);  // Convert to integer

// Database connection
$link = new mysqli("localhost", "root", "", "cinema_db");

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

// Prepare SQL statement
$sql = "DELETE FROM bookingTable WHERE bookingID = ?";
$stmt = $link->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $stmt->close();
        $link->close();
        header("Location: admin.php");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
} else {
    echo "Error preparing statement: " . $link->error;
}

$link->close();
?>
