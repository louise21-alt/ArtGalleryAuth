<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if ArtworkID is set in the query string
if (isset($_GET['ArtworkID'])) {
  $artworkID = $_GET['ArtworkID'];
  $artwork = fetchArtworkByID($pdo, $artworkID); // Fetch current artwork data
} else {
  echo "No artwork selected for editing.";
  exit;
}

// Variable to track update result
$updateMessage = '';
$formVisible = true; // Track if the form should be visible

if (isset($_POST['editArtworkBtn'])) {
  $title = $_POST['title'];
  $artist = $_POST['artist'];
  $yearCreated = $_POST['yearCreated'];

  // Call function to update artwork
  $query = updateArtwork($pdo, $artworkID, $title, $artist, $yearCreated);

  if ($query) {
    $updateMessage = "Artwork updated successfully!";
    $formVisible = false;
  } else {
    $updateMessage = "Failed to update artwork!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Artwork</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .link {
      text-align: right;
      margin-top: 20px;
    }

    .update-message {
      color: green;
      /* Style for success message */
      margin-bottom: 20px;
      text-align: center;
    }

    .error-message {
      color: red;
      /* Style for error message */
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <header>
    <h1>Edit Artwork</h1>
  </header>

  <main>
    <?php if ($updateMessage): ?>
      <p class="update-message"><?php echo $updateMessage; ?></p>
    <?php endif; ?>

    <?php if ($formVisible): ?>
      <form method="POST" action="">
        <input type="hidden" name="ArtworkID" value="<?php echo htmlspecialchars($artwork['ArtworkID']); ?>">

        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($artwork['Title']); ?>" required>

        <label for="artist">Artist:</label>
        <input type="text" name="artist" id="artist" value="<?php echo htmlspecialchars($artwork['Artist']); ?>" required>

        <label for="yearCreated">Year Created:</label>
        <input type="number" name="yearCreated" id="yearCreated"
          value="<?php echo htmlspecialchars($artwork['YearCreated']); ?>" required>

        <input type="submit" name="editArtworkBtn" value="Update Artwork">
      </form>
    <?php endif; ?>

    <div class="link">
      <a href="index.php">Return Home</a> <!-- Always visible -->
    </div>
  </main>
</body>

</html>