<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

$galleries = fetchAllGalleries($pdo); // Fetch all galleries
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Galleries</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    h5 {
      text-align: right;
    }

    h1 {
      color: #3b2e2e;
      font-size: 2rem;
    }

    .header-actions a {
      color: #3b2e2e;
      font-size: 1.2rem;
    }
  </style>
</head>

<body>
  <header>
    <h1>Art Gallery</h1>
    <div class="header-actions">
      <a href="addGallery.php">Add New Gallery</a>
    </div>
  </header>

  <main>
    <h5><a href="index.php">Back to Artwork</a></h5>
    <table>
      <thead>
        <tr>
          <th>Gallery Name</th>
          <th>Location</th>
          <th>Description</th>
          <th>Contact Info</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($galleries as $gallery): ?>
          <tr>
            <td><?php echo htmlspecialchars($gallery['GalleryName']); ?></td>
            <td><?php echo htmlspecialchars($gallery['Location']); ?></td>
            <td><?php echo htmlspecialchars($gallery['Description']); ?></td>
            <td><?php echo htmlspecialchars($gallery['ContactInfo']); ?></td>

            <td>
              <a href="editGallery.php?GalleryID=<?php echo $gallery['GalleryID']; ?>">Edit</a>
              <a href="deleteGallery.php?GalleryID=<?php echo $gallery['GalleryID']; ?>">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>

</html>