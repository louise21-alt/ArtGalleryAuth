<?php
require_once 'dbConfig.php';

// Function to get all artworks
function getAllArtworks($pdo)
{
    $stmt = $pdo->query("SELECT * FROM Artwork"); // Assuming 'Artwork' is the correct table name
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchArtworks($pdo)
{
    $sql = "
        SELECT 
            Artwork.ArtworkID, 
            Artwork.Title, 
            Artwork.Artist, 
            Artwork.YearCreated,
            Artwork.added_by,
            Artwork.last_updated, 
            ArtGallery.GalleryName 
        FROM Artwork
        LEFT JOIN ArtGallery ON Artwork.GalleryID = ArtGallery.GalleryID
    ";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch a specific artwork by ID
function fetchArtworkByID($pdo, $artworkID)
{
    $sql = "SELECT * FROM Artwork WHERE ArtworkID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$artworkID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function addArtwork($pdo, $Title, $Artist, $YearCreated, $added_by)
{
    $sql = "INSERT INTO Artwork (Title, Artist, YearCreated, added_by) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$Title, $Artist, $YearCreated, $added_by]);
}

function updateArtwork($pdo, $artworkID, $title, $artist, $yearCreated)
{
    $sql = "UPDATE Artwork SET Title = ?, Artist = ?, YearCreated = ?, last_updated = CURRENT_TIMESTAMP WHERE ArtworkID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$title, $artist, $yearCreated, $artworkID]);
}


// Function to delete an artwork
function deleteArtwork($pdo, $artworkID)
{
    $sql = "DELETE FROM Artwork WHERE ArtworkID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$artworkID]);
}



function addGallery($pdo, $galleryName, $location, $description, $contactInfo)
{
    $stmt = $pdo->prepare("INSERT INTO ArtGallery (GalleryName, Location, Description, ContactInfo) VALUES (:galleryName, :location, :description, :contactInfo)");
    $stmt->bindParam(':galleryName', $galleryName);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':contactInfo', $contactInfo);
    return $stmt->execute();
}

function fetchGalleryByID($pdo, $galleryID)
{
    $stmt = $pdo->prepare("SELECT * FROM ArtGallery WHERE GalleryID = :galleryID");
    $stmt->bindParam(':galleryID', $galleryID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateGallery($pdo, $galleryID, $galleryName, $location, $description, $contactInfo)
{
    $stmt = $pdo->prepare("UPDATE ArtGallery SET GalleryName = :galleryName, Location = :location, Description = :description, ContactInfo = :contactInfo WHERE GalleryID = :galleryID");
    $stmt->bindParam(':galleryID', $galleryID, PDO::PARAM_INT);
    $stmt->bindParam(':galleryName', $galleryName);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':contactInfo', $contactInfo);
    return $stmt->execute();
}

function deleteGallery($pdo, $galleryID)
{
    $stmt = $pdo->prepare("DELETE FROM ArtGallery WHERE GalleryID = :galleryID");
    $stmt->bindParam(':galleryID', $galleryID, PDO::PARAM_INT);
    return $stmt->execute();
}


function fetchAllGalleries($pdo)
{
    $stmt = $pdo->query("SELECT * FROM ArtGallery");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
