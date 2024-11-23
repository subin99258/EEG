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
(11, 'manager', 'Dr', 'Test', 'User', 'manager@eegdata.com', 'e77afa77068657d76cd189d11c5cffe7dafc6358cfbac055b6fc1dd8ae051c3d', 'Univeristy of Southern Queensland', 'Manager Account', 0),
(12, 'testUser1', 'Mr', 'Jason', 'Lee', 'jason@sampleorg.com', '897326419f171e9c6144b194392cbdc3dbceaab1f80d3cbdb952b161b2fc5bcb', 'Test profile 1', 'Test profile 1', 2),
(13, 'testUser2', 'Professor', 'Andrew', 'Wilson', 'awilson@sampleorg.com', '897326419f171e9c6144b194392cbdc3dbceaab1f80d3cbdb952b161b2fc5bcb', 'Test profile 2', 'Test profile 3', 1),
(14, 'testUser3', 'Mrs', 'Gunter', 'Wendt', 'gunter@sampleorg.com', '897326419f171e9c6144b194392cbdc3dbceaab1f80d3cbdb952b161b2fc5bcb', 'Test profile 3', 'Test profile 3', 2),
(15, 'testUser4', 'Ms', 'Gina', 'Fiori', 'gfiori@sampleorg.com', '897326419f171e9c6144b194392cbdc3dbceaab1f80d3cbdb952b161b2fc5bcb', 'Test profile 4', 'Test profile 4', 1);

-- Create publication table
CREATE TABLE publication (
    pubID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userID int NOT NULL,
    pubTitle varchar(255) NOT NULL,
    pubDesc varchar(255) NOT NULL,
    pubPath varchar(255) NOT NULL,
    approved TINYINT(1) DEFAULT 0,
    FOREIGN KEY (userID) REFERENCES researcher(userID)
);

-- Insert sample data into publication table
INSERT INTO publication (pubID, userID, pubTitle, pubDesc, pubPath, approved)
VALUES
(1, 11, 'TESTSAMPLE tvMVAR Critical Connectivity Comparison', 'TEST SAMPLE Comparison of brain interaction models, optimizing parameters for dynamic signal analysis.', '../uploads/pub_uploads/tvMVAR_Critical_Connectivity_Comparison.pdf', 1),
(2, 11, 'TESTSAMPLE Cluster tests of MEG/EEG data', 'TEST SAMPLE Cluster permutation tests do not validate effect timing or spatial significance..', '../uploads/pub_uploads/cluster_tests.pdf', 0),
(3, 11, 'TESTSAMPLE Phantom Shapes on gradient artifact', 'TEST SAMPLE scanner during the simultaneous acquisition of EEG and functional magnetic resonance imaging (fMRI) data', '../uploads/pub_uploads/ml_beginners.pdf', 0);

-- Create eeg table
CREATE TABLE eeg (
    eegID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userID int NOT NULL,
    eegTitle varchar(255) NOT NULL,
    eegDesc varchar(255) NOT NULL,
    eegPath varchar(255) NOT NULL,
    pubID int,
    approved TINYINT(1) DEFAULT 0,
    FOREIGN KEY(userID) REFERENCES researcher(userID)
);

-- Insert sample data into eeg table
INSERT INTO eeg (eegID, userID, eegTitle, eegDesc, eegPath, pubID, approved)
VALUES
(1, 11, 'EEG_Dh7g_20090902_1-4', 'Sample Data 1', '../uploads/eeg_uploads/EEG_Dh7g_20090902_1-4.pdf', 1, 1),
(2, 11, 'EEG_Dh7g_20090902_5-8', 'Sample Data 2', '../uploads/eeg_uploads/EEG_Dh7g_20090902_5-8.pdf', NULL, 1),
(3, 11, 'EEG_Dh7g_20090902_9-12', 'Sample Data 3', '../uploads/eeg_uploads/EEG_Dh7g_20090902_9-12.pdf', NULL, 0),
(4, 12, 'EEG_Dh7g_20090902_13-16', 'Sample Data 4', '../uploads/eeg_uploads/EEG_Dh7g_20090902_13-16.pdf', NULL, 0),
(5, 12, 'EEG_Dh7g_20090902_17-20', 'Sample Data 5', '../uploads/eeg_uploads/EEG_Dh7g_20090902_17-20.pdf', NULL, 0);

-- Create `public` table (using different name due to reserved keyword)
CREATE TABLE `public_users` (
    downloadedID int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    eegTitle varchar(255) NOT NULL, 
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    eegID int,
    viewed_time datetime,
    FOREIGN KEY (eegID) REFERENCES eeg(eegID) 
);

-- Insert sample data into `public` table
INSERT INTO `public_users` (downloadedID, eegTitle, firstName, lastName, email, eegID, viewed_time)
VALUES
(1001, 'EEG_Dh7g_20090902_1-4', 'Public', 'Test', 'test@publicuser.com', 1, '2024-07-10 09:39:22'),
(1002, 'EEG_Dh7g_20090902_5-8', 'Test', 'User', 'public@testuser.com', 2, '2024-07-12 09:39:22');


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

-- update rows link eeg data and publication to each other
UPDATE `publication`
SET eegID = '1'
WHERE pubID = '1';

-- extra sample
INSERT INTO researcher (userID, username, resTitle, firstName, lastName, email, password, organisation, profile, userRole)
VALUES
(16, 'userTester', 'Ms', 'Tess', 'Terr', 'a@a.com', '7097891803c4f5a0f5784391c95d762e9baefc120a5ea22782907398e67a7dbb', 'main tester sampler person', 'User this researcher Person to test', 2);



-- Create a sample db admin user
GRANT SELECT, INSERT, UPDATE, DELETE
ON EEG_data_and_publication_platform.*
TO eeg_publications_user@localhost
IDENTIFIED BY 'pa55word';
