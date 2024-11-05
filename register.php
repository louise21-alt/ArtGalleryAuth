<?php
require_once 'core/dbConfig.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  // Check if the username already exists
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE Username = ?");
  $stmt->execute([$username]);
  $count = $stmt->fetchColumn();

  if ($count > 0) {
    $message = "Username already exists. Please choose a different one.";
  } else {
    // Proceed with registration if the username is unique
    $stmt = $pdo->prepare("INSERT INTO Users (Username, Password) VALUES (?, ?)");
    if ($stmt->execute([$username, $password])) {
      $message = "Registration successful! <a href='login.php'>Login here</a>";
    } else {
      $message = "Error: Could not register.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <main>
    <form method="POST" action="">
      <label>Username:</label>
      <input type="text" name="username" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <button type="submit">Register</button>

      <?php if ($message): ?>
        <p style="margin-top: 10px;"><?php echo $message; ?></p>
      <?php endif; ?>
    </form>
  </main>
</body>

</html>