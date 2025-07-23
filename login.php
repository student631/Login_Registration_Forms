<?php
session_start();
include 'db.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields!";
    } else {
        // Check user in DB
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // VERIFY THE HASHED PASSWORD
            if (password_verify($password, $user['password'])) {
                $success = "Login successful! Welcome " . htmlspecialchars($user['fullname']) . ".";
                // Store user in session if needed
                $_SESSION['user'] = $user;
                 header("Location: users.php");
           exit();
                 } else {
                   $error = "Incorrect password!";
            }
        } else {
            $error = "No account found with this email!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>
