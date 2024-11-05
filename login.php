<?php
session_start();
require_once 'core/dbConfig.php';

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM Users WHERE Username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['Password'])) {
    $_SESSION['user'] = $user['Username'];
    header("Location: index.php");
    exit;
  } else {
    $errorMessage = "Invalid credentials.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <main>
    <form method="POST" action="">
      <label>Username:</label>
      <input type="text" name="username" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <button type="submit">Login</button>

      <?php if ($errorMessage): ?>
        <p style="color: red; margin-top: 10px;"><?php echo $errorMessage; ?></p>
      <?php endif; ?>
    </form>
    <p style="margin-top: 20px">Don't have an account? <a href="register.php">Click here to register</a></p>
  </main>
</body>

</html>