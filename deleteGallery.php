<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if GalleryID is set in the query string
if (isset($_GET['GalleryID'])) {
  $galleryID = $_GET['GalleryID'];
  $gallery = fetchGalleryByID($pdo, $galleryID); // Fetch gallery details for confirmation

  if (!$gallery) {
    echo "Gallery not found.";
    exit;
  }
} else {
  echo "No gallery selected for deletion.";
  exit;
}

// Variable to track deletion result
$deletionMessage = '';
$formVisible = true; // Track if the confirmation form should be visible

// Check if the form is submitted
if (isset($_POST['deleteGalleryBtn'])) {
  $query = deleteGallery($pdo, $galleryID); // Call function to delete gallery

  if ($query) {
    $deletionMessage = "Gallery deleted successfully!";
    $formVisible = false; // Hide the form on successful deletion
  } else {
    $deletionMessage = "Failed to delete gallery!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Gallery</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    form {
      margin-top: 20px;
    }

    .link {
      text-align: center;
      margin-top: 20px;
      text-align: right;
    }

    .link,
    a {
      color: red;
      text-decoration: none;
    }

    .success-message {
      color: green;
      text-align: center;
      margin-bottom: 20px;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <header>
    <h1>Delete Gallery</h1>
  </header>

  <main>
    <?php if ($deletionMessage): ?>
      <p class="success-message"><?php echo $deletionMessage; ?></p>
      <div class="link">
        <a href="viewGallery.php">Return to Gallery</a>
      </div>
    <?php elseif ($formVisible): ?>
      <p>Are you sure you want to delete the gallery
        "<strong><?php echo htmlspecialchars($gallery['GalleryName']); ?></strong>"?
      </p>
      <form method="POST">
        <input type="hidden" name="GalleryID" value="<?php echo $galleryID; ?>">
        <input type="submit" name="deleteGalleryBtn" value="Yes, Delete">
      </form>
      <div class="link">
        <a href="viewGallery.php">Cancel</a>
      </div>
    <?php endif; ?>
  </main>
</body>

</html>