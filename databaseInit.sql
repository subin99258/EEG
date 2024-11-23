-- Create the database
DROP DATABASE IF EXISTS EEG_data_and_publication_platform;
CREATE DATABASE EEG_data_and_publication_platform;
USE EEG_data_and_publication_platform;

-- Create researcher table
CREATE TABLE researcher (
    userID int NOT NULL AUTO_INCREMENT,
    username varchar(50) NOT NULL UNIQUE,
    resTitle varchar(50) NOT NULL, 
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    password varchar(65) NOT NULL,
    organisation varchar (100) NOT NULL,
    profile varchar (255) NOT NULL,
    userRole int, -- 0 = manager/admin, 1 = publicResearcher, 2 = approvedResearcher
    PRIMARY KEY (userID),

    -- Unique constraints
    UNIQUE KEY unique_email (email),
    UNIQUE KEY unique_username (username)
);

-- Insert sample data into researcher table
INSERT INTO researcher (userID, username, resTitle, firstName, lastName, email, password, organisation, profile, userRole)
VALUES
(11, 'manager', 'Dr', 'Test', 'User', 'manager@eegdata.com', 'e77afa77068657d76cd189d11c5cffe7dafc6358cfbac055b6fc1dd8ae051c3d', 'Univeristy of Southern Queensland', 'Manager Account', 0);

-- Create publication table with pubDate
CREATE TABLE publication (
    pubID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userID int NOT NULL,
    pubTitle varchar(255) NOT NULL,
    pubDesc varchar(255) NOT NULL,
    pubPath varchar(255) NOT NULL,
    approved TINYINT(1) DEFAULT 0,
    pubDate DATE DEFAULT NULL,
    FOREIGN KEY (userID) REFERENCES researcher(userID)
);

-- Create eeg table with eegDate
CREATE TABLE eeg (
    eegID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userID int NOT NULL,
    eegTitle varchar(255) NOT NULL,
    eegDesc varchar(255) NOT NULL,
    eegPath varchar(255) NOT NULL,
    pubID int,
    approved TINYINT(1) DEFAULT 0,
    eegDate DATE DEFAULT NULL, 
    FOREIGN KEY(userID) REFERENCES researcher(userID)
);


-- Create `public` table (using different name due to reserved keyword)
CREATE TABLE `public_users` (
    downloadedID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    eegTitle varchar(255) NOT NULL, 
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    eegID int,
    viewed_time datetime,
    token VARCHAR(255),
    FOREIGN KEY (eegID) REFERENCES eeg(eegID) 
);

-- Alter the publication table to add eegID column
ALTER TABLE publication
ADD COLUMN eegID int,
ADD CONSTRAINT FK_pub_link_eeg FOREIGN KEY (eegID)
REFERENCES eeg(eegID)
ON DELETE CASCADE
ON UPDATE CASCADE;

-- Alter the eeg table to add pubID column
ALTER TABLE eeg
ADD CONSTRAINT FK_eeg_publication FOREIGN KEY (pubID)
REFERENCES publication(pubID)
ON DELETE CASCADE
ON UPDATE CASCADE;

-- Create a sample db admin user
GRANT SELECT, INSERT, UPDATE, DELETE
ON EEG_data_and_publication_platform.*
TO eeg_publications_user@localhost
IDENTIFIED BY 'pa55word';