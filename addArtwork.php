<?php
session_start(); // Start the session to access $_SESSION variables
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Variable to track addition result
$additionMessage = '';
$formVisible = true; // Track if the form should be visible

if (isset($_POST['submitArtworkButton'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $yearCreated = $_POST['yearCreated'];

    // Check if the 'username' exists in the session
    if (isset($_SESSION['user'])) {
        $added_by = $_SESSION['user']; // Get the current user's username from the session

        // Call function to add artwork with the added_by value
        $query = addArtwork($pdo, $title, $artist, $yearCreated, $added_by);

        if ($query) {
            $additionMessage = "Artwork added successfully!";
            $formVisible = false;
        } else {
            $additionMessage = "Failed to add artwork!";
        }
    } else {
        $additionMessage = "You must be logged in to add artwork.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Artwork</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .link {
            text-align: right;
            margin-top: 20px;
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
        <h1>Add New Artwork</h1>
    </header>

    <main>
        <?php if ($additionMessage): ?>
            <p class="success-message"><?php echo $additionMessage; ?></p>
        <?php endif; ?>

        <?php if ($formVisible): ?>
            <form method="POST" action="">
                <input type="hidden" name="ArtworkID" id="ArtworkID">
                <label for="title">Title:</label>
                <input type="text" name="title" required>
                <label for="artist">Artist:</label>
                <input type="text" name="artist" required>
                <label for="yearCreated">Year Created:</label>
                <input type="number" name="yearCreated" required>
                <input type="submit" name="submitArtworkButton" value="Add Artwork">
            </form>
        <?php endif; ?>

        <div class="link">
            <a href="index.php">Back to Gallery</a>
        </div>
    </main>
</body>

</html>