<?php
include 'db.php';

$id = $_GET['id'] ?? '';
$error = '';
$success = '';

if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        die("User not found!");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $query = "UPDATE users SET fullname='$fullname', email='$email' WHERE id='$id'";
        if (mysqli_query($conn, $query)) {
            $success = "User updated successfully!";
            header("Location: users.php");
            exit();
        } else {
            $error = "Error updating user: " . mysqli_error($conn);
        }
    }
} else {
    die("No user ID provided!");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required><br><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>
        <button type="submit">Update</button>
    </form>
    <p><a href="users.php">Back to User List</a></p>
</body>
</html>
