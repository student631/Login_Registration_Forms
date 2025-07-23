<?php
include 'db.php';

$id = $_GET['id'] ?? '';

if ($id) {
    $query = "DELETE FROM users WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
} else {
    echo "No user ID provided!";
}
?>
