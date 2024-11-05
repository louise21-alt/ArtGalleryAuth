<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if GalleryID is set in the query string
if (isset($_GET['GalleryID'])) {
  $galleryID = $_GET['GalleryID'];
  $gallery = fetchGalleryByID($pdo, $galleryID); // Fetch gallery details
} else {
  echo "No gallery selected for editing.";
  exit;
}

// Variable to track update result
$updateMessage = '';
$formVisible = true; // Flag to control form visibility

// Check if the form is submitted
if (isset($_POST['editGalleryBtn'])) {
  $galleryName = $_POST['galleryName'];
  $location = $_POST['location'];
  $description = $_POST['description'];
  $contactInfo = $_POST['contactInfo'];

  // Call function to update gallery
  $query = updateGallery($pdo, $galleryID, $galleryName, $location, $description, $contactInfo);

  if ($query) {
    $updateMessage = "Gallery updated successfully!";
    $formVisible = false; // Hide the form if successful
  } else {
    $updateMessage = "Failed to update gallery!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Gallery</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .link {
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
    <h1>Edit Gallery</h1>
  </header>

  <main>
    <?php if ($updateMessage): ?>
      <!-- Display update message -->
      <p class="<?php echo strpos($updateMessage, 'successfully') !== false ? 'message' : 'error-message'; ?>">
        <?php echo $updateMessage; ?>
      </p>
    <?php endif; ?>

    <?php if ($formVisible): ?>
      <!-- Display the form only if it's visible -->
      <form method="POST">
        <label for="galleryName">Gallery Name:</label>
        <input type="text" name="galleryName" value="<?php echo htmlspecialchars($gallery['GalleryName']); ?>" required>

        <label for="location">Location:</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($gallery['Location']); ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($gallery['Description']); ?></textarea>

        <label for="contactInfo">Contact Info:</label>
        <input type="text" name="contactInfo" value="<?php echo htmlspecialchars($gallery['ContactInfo']); ?>" required>

        <input type="submit" name="editGalleryBtn" value="Update Gallery">
      </form>
    <?php endif; ?>

    <div class="link">
      <a href="viewGallery.php">Back to Gallery</a>
    </div>
  </main>
</body>

</html>