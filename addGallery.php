<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Variable to track addition result
$additionMessage = '';
$formVisible = true; // Flag to control form visibility

if (isset($_POST['addGalleryBtn'])) {
  $galleryName = $_POST['galleryName'];
  $location = $_POST['location'];
  $description = $_POST['description'];
  $contactInfo = $_POST['contactInfo'];

  // Call function to add gallery
  $query = addGallery($pdo, $galleryName, $location, $description, $contactInfo);

  if ($query) {
    $additionMessage = "Gallery added successfully!";
    $formVisible = false; // Hide the form if successful
  } else {
    $additionMessage = "Failed to add gallery!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Gallery</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .links {
      text-align: right;
      margin-top: 20px;
    }

    .message {
      text-align: center;
      margin-bottom: 20px;
      color: green;
      /* Color for success messages */
    }

    .error-message {
      text-align: center;
      margin-bottom: 20px;
      color: red;
      /* Color for error messages */
    }
  </style>
</head>

<body>
  <header>
    <h1>Add New Gallery</h1>
  </header>

  <main>
    <?php if ($additionMessage): ?>
      <!-- Display addition message -->
      <p class="<?php echo strpos($additionMessage, 'successfully') !== false ? 'message' : 'error-message'; ?>">
        <?php echo $additionMessage; ?>
      </p>
    <?php endif; ?>

    <?php if ($formVisible): ?>
      <!-- Display the form only if it's visible -->
      <form method="POST">
        <label for="galleryName">Gallery Name:</label>
        <input type="text" name="galleryName" required>

        <label for="location">Location:</label>
        <input type="text" name="location" required>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <label for="contactInfo">Contact Info:</label>
        <input type="text" name="contactInfo" required>
        <input type="submit" name="addGalleryBtn" value="Add Gallery">
      </form>
    <?php endif; ?>

    <div class="links">
      <a href="viewGallery.php">Back to Gallery</a>
    </div>
  </main>
</body>

</html>