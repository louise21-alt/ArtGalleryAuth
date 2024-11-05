<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once 'core/dbConfig.php';
require_once 'core/models.php';

$artworks = fetchArtworks($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Art Gallery</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        h1 {
            color: #3b2e2e;
            font-size: 2rem;
        }

        .header-actions a {
            color: #3b2e2e;
            font-size: 1.2rem;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .logout {
            text-align: right;
        }

        .logout a {
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h1>Art Gallery</h1>
        <div class="header-actions">
            <a href="addArtwork.php">Add New Artwork</a>
        </div>
    </header>

    <main>
        <div class="header">
            <h2>Artworks</h2>
            <p class="logout"><a href="logout.php">Logout</a></p>
        </div>
        <table>
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Year Created</th>
                    <th>Added By</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($artworks as $row): ?>
                    <tr>
                        <!-- <td><?php echo htmlspecialchars($row['ArtworkID']); ?></td> -->
                        <td><?php echo htmlspecialchars($row['Title']); ?></td>
                        <td><?php echo htmlspecialchars($row['Artist']); ?></td>
                        <td><?php echo htmlspecialchars($row['YearCreated']); ?></td>
                        <td><?php echo htmlspecialchars($row['added_by']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_updated']); ?></td>
                        <td>
                            <a href="viewGallery.php?ArtworkID=<?php echo $row['ArtworkID']; ?>">View</a>
                            <a href="editArtwork.php?ArtworkID=<?php echo $row['ArtworkID']; ?>">Edit</a>
                            <a href="deleteArtwork.php?ArtworkID=<?php echo $row['ArtworkID']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>

</html>