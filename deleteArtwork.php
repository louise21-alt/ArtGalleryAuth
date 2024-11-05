<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if ArtworkID is set in the URL
if (isset($_GET['ArtworkID'])) {
  $artworkID = $_GET['ArtworkID'];
  $artwork = fetchArtworkByID($pdo, $artworkID); // Fetch the artwork details for confirmation

  if (!$artwork) {
    echo "Artwork not found.";
    exit;
  }
} else {
  // Handle the case where ArtworkID is not set
  echo "No artwork selected for deletion.";
  exit;
}

// Variable to track deletion result
$deletionMessage = '';
$formVisible = true; // Track if the confirmation form should be visible

if (isset($_POST['deleteArtworkBtn'])) {
  $artworkID = $_POST['ArtworkID'];

  // Call the delete function
  $query = deleteArtwork($pdo, $artworkID);

  if ($query) {
    $deletionMessage = "Artwork deleted successfully!<br><br>";
    $formVisible = false; // Hide the form on successful deletion
  } else {
    $deletionMessage = "Failed to delete artwork!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Artwork</title>
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
      /* Style for success message */
      text-align: center;
      margin-bottom: 20px;
    }

    .error-message {
      color: red;
      /* Style for error message */
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <header>
    <h1>Delete Artwork</h1>
  </header>

  <main>
    <?php if ($deletionMessage): ?>
      <p class="success-message"><?php echo $deletionMessage; ?></p>
      <div class="link">
        <a href="index.php">Return to Artwork</a>
      </div>
    <?php elseif ($formVisible): ?>
      <p>Are you sure you want to delete the artwork titled
        "<strong><?php echo htmlspecialchars($artwork['Title']); ?></strong>" by
        <?php echo htmlspecialchars($artwork['Artist']); ?>?
      </p>
      <form method="POST">
        <input type="hidden" name="ArtworkID" value="<?php echo $artworkID; ?>"> <!-- Hidden input for ArtworkID -->
        <input type="submit" name="deleteArtworkBtn" value="Yes, Delete">
      </form>
      <div class="link">
        <a href="index.php">Cancel</a> <!-- This link is shown only if deletion is not attempted -->
      </div>
    <?php endif; ?>
  </main>
</body>

</html>