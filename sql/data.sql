CREATE TABLE ArtGallery (
    GalleryID INT PRIMARY KEY,
    GalleryName VARCHAR(255) NOT NULL,
    Location VARCHAR(255)
);

CREATE TABLE Artwork (
    ArtworkID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Artist VARCHAR(255) NOT NULL,
    YearCreated INT,
    GalleryID INT,
    FOREIGN KEY (GalleryID) REFERENCES ArtGallery(GalleryID)
);

ALTER TABLE ArtGallery
ADD COLUMN Description TEXT,
ADD COLUMN ContactInfo VARCHAR(255);

ALTER TABLE ArtGallery MODIFY COLUMN GalleryID INT AUTO_INCREMENT;

-- Add user tracking columns to Artwork table
ALTER TABLE Artwork
ADD COLUMN added_by VARCHAR(255),
ADD COLUMN last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL -- Store hashed passwords
);
