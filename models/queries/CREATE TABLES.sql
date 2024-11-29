CREATE DATABASE IF NOT EXISTS db_pcwi;

USE db_pcwi;

DROP TABLE IF EXISTS Purchases;

DROP TABLE IF EXISTS PurchasedLevels;

DROP TABLE IF EXISTS Kardex;

DROP TABLE IF EXISTS DeletedComments;

DROP TABLE IF EXISTS Comments;

DROP TABLE IF EXISTS Contents;

DROP TABLE IF EXISTS CompletedLevels;

DROP TABLE IF EXISTS Levels;

DROP TABLE IF EXISTS Courses;

DROP TABLE IF EXISTS Categories;

DROP TABLE IF EXISTS Messages;

DROP TABLE IF EXISTS Users;

CREATE TABLE Users (
    userId INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the user',
    creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'User creation date',
    modificationDate DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'User modification date',
    status CHAR DEFAULT 'A' COMMENT 'User status',
    failedAttempts INT NOT NULL DEFAULT 0 COMMENT 'Failed attempts',
    username VARCHAR(20) NOT NULL COMMENT 'Username',
    fullName VARCHAR(75) NOT NULL COMMENT 'Full name of the user',
    email VARCHAR(50) UNIQUE NOT NULL COMMENT 'User email',
    password VARCHAR(95) NOT NULL COMMENT 'User password',
    role CHAR NOT NULL COMMENT 'User role',
    birthDate DATE NOT NULL COMMENT 'User birth date',
    profilePicture LONGBLOB NOT NULL COMMENT 'User profile picture',
    gender CHAR NOT NULL COMMENT 'User gender',
    PRIMARY KEY (userId),
    INDEX (role),
    INDEX (status)
) COMMENT = 'User table';

CREATE TABLE Categories (
    categoryId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the category',
    creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Category creation date',
    modificationDate DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Category modification date',
    deactivationDate DATETIME DEFAULT NULL COMMENT 'Category deactivation date',
    categoryName VARCHAR(50) NOT NULL COMMENT 'Category name',
    categoryDescription TEXT NOT NULL COMMENT 'Category description',
    creatorId INT NOT NULL COMMENT 'Foreign key of the category creator',
    FOREIGN KEY (creatorId) REFERENCES Users (userId)
) COMMENT 'Category table';

CREATE TABLE Courses (
    courseId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the course',
    creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Course creation date',
    modificationDate DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Course modification date',
    deactivationDate DATETIME DEFAULT NULL COMMENT 'Course deactivation date',
    courseDescription TEXT NOT NULL COMMENT 'Course description',
    courseTitle VARCHAR(50) NOT NULL COMMENT 'Course title',
    courseImage LONGBLOB NOT NULL COMMENT 'Course image',
    categoryId INT NOT NULL COMMENT 'Foreign key of the course category',
    instructorId INT NOT NULL COMMENT 'Foreign key of the instructor',
    coursePrice DECIMAL(10, 2) NULL COMMENT 'Course price',
    FOREIGN KEY (instructorId) REFERENCES Users (userId),
    FOREIGN KEY (categoryId) REFERENCES Categories (categoryId),
    INDEX (categoryId)
) COMMENT 'Course table';

CREATE TABLE Levels (
    levelId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the level',
    creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Level creation date',
    modificationDate DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Level modification date',
    deactivationDate DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Level deactivation date',
    `active` BOOLEAN NULL  DEFAULT TRUE COMMENT 'Level status',
    levelName VARCHAR(50) NOT NULL COMMENT 'Level name',
    levelNumber INT NOT NULL COMMENT 'Level number',
    levelDescription TEXT NOT NULL COMMENT 'Level description',
    levelCost DECIMAL(10, 2) NULL COMMENT 'Level cost',
    courseId INT NOT NULL COMMENT 'Foreign key of the course',
    FOREIGN KEY (courseId) REFERENCES Courses (courseId),
    INDEX (courseId)
) COMMENT 'Level table';

CREATE TABLE Contents (
    contentId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the content',
    mimeType VARCHAR(128) NOT NULL COMMENT 'Content type',
    file LONGBLOB NOT NULL COMMENT 'Content file',
    name VARCHAR(128) NOT NULL COMMENT 'File Name',
    levelId INT NOT NULL COMMENT 'Foreign key of the level',
    FOREIGN KEY (levelId) REFERENCES Levels (levelId),
    INDEX (levelId)
) COMMENT 'Content table';

CREATE TABLE Messages (
    messageId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the message',
    creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Message creation date',
    message TEXT NOT NULL COMMENT 'Message',
    senderId INT NOT NULL COMMENT 'Foreign key of the message sender',
    receiverId INT NOT NULL COMMENT 'Foreign key of the message receiver',
    FOREIGN KEY (senderId) REFERENCES Users (userId),
    FOREIGN KEY (receiverId) REFERENCES Users (userId),
    INDEX (senderId),
    INDEX (receiverId)
) COMMENT 'Message table';

CREATE TABLE Kardex (
    startDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Course start date in the kardex',
    accessDate DATETIME DEFAULT NULL COMMENT 'Last access date to the course in the kardex',
    completionDate DATETIME DEFAULT NULL COMMENT 'Course completion date',
    userId INT NOT NULL COMMENT 'Foreign key of the user',
    courseId INT NOT NULL COMMENT 'Foreign key of the course',
    PRIMARY KEY (userId, courseId),
    FOREIGN KEY (userId) REFERENCES Users (userId),
    FOREIGN KEY (courseId) REFERENCES Courses (courseId),
    INDEX (courseId),
    INDEX (userId)
) COMMENT 'Kardex table';

CREATE TABLE Purchases (
    purchaseId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the purchase',
    purchaseDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Purchase date',
    userId INT NOT NULL COMMENT 'Foreign key of the user',
    courseId INT NOT NULL COMMENT 'Foreign key of the course',
    levelId INT NULL COMMENT 'Foreign key of the level, NULL if the purchase is for a course',
    paymentMethod VARCHAR(20) NOT NULL COMMENT 'Payment method',
    paymentType ENUM('L', 'C') NOT NULL COMMENT 'Course payment type L for level and C for course',
    paymentAmount DECIMAL(10, 2) NOT NULL COMMENT 'Payment amount',
    FOREIGN KEY (userId) REFERENCES Users (userId),
    FOREIGN KEY (courseId) REFERENCES Courses (courseId),
    INDEX (courseId),
    INDEX (userId)
) COMMENT 'Purchase table';

CREATE TABLE PurchasedLevels (
    levelId INT NOT NULL COMMENT 'Foreign key of the level',
    userId INT NOT NULL COMMENT 'Foreign key of the user',
    completed BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Level completion status',
    PRIMARY KEY (levelId, userId),
    FOREIGN KEY (levelId) REFERENCES Levels (levelId),
    FOREIGN KEY (userId) REFERENCES Users (userId)
) COMMENT 'Purchased levels table';

CREATE TABLE Comments (
    commentId INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the comment',
    creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Comment creation date',
    deactivationDate DATETIME NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Comment deactivation date',
    rating INT NOT NULL COMMENT 'Course rating',
    comment TEXT NOT NULL COMMENT 'Comment',
    userId INT NOT NULL COMMENT 'Foreign key of the user',
    courseId INT NOT NULL COMMENT 'Foreign key of the course',
    FOREIGN KEY (userId) REFERENCES Users (userId),
    FOREIGN KEY (courseId) REFERENCES Courses (courseId),
    INDEX (courseId),
    INDEX (userId)
) COMMENT 'Comment table';

CREATE TABLE DeletedComments (
    adminUserId INT NOT NULL COMMENT 'Foreign key of the admin user who deletes the comment',
    commentId INT NOT NULL COMMENT 'Foreign key of the deleted comment',
    deactivationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Comment deletion date',
    deletionReason TEXT NOT NULL COMMENT 'Reason for comment deletion',
    PRIMARY KEY (adminUserId, commentId),
    FOREIGN KEY (adminUserId) REFERENCES Users (userId),
    FOREIGN KEY (commentId) REFERENCES Comments (commentId)
) COMMENT 'Deleted comments table';
