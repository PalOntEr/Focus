DROP PROCEDURE IF EXISTS sp_Users;

DELIMITER $$

CREATE PROCEDURE sp_Users
(
    IN Op INT,
    IN sp_userId INT,
    IN sp_status CHAR,
    IN sp_username VARCHAR(30),
    IN sp_fullName VARCHAR(100),
    IN sp_email VARCHAR(100),
    IN sp_password VARCHAR(100),
    IN sp_creationDate DATETIME,
    IN sp_modificationDate DATETIME,
    IN sp_role CHAR,
    IN sp_birthdate DATE,
    IN sp_profilePicture LONGBLOB,
    IN sp_gender CHAR
)
BEGIN
    CASE Op
        WHEN 1 THEN
            INSERT INTO Users(username, fullName, email, password, role, birthdate, profilePicture, gender)
            VALUES(sp_username, sp_fullName, sp_email, sp_password, sp_role, sp_birthdate, sp_profilePicture, sp_gender);
        
        WHEN 2 THEN
            UPDATE Users
            SET
                username = IFNULL(sp_username, username),
                fullName = IFNULL(sp_fullName, fullName),
                email = IFNULL(sp_email, email),
                password = IFNULL(sp_password, password),
                role = IFNULL(sp_role, role),
                birthdate = IFNULL(sp_birthdate, birthdate),
                profilePicture = IFNULL(sp_profilePicture, profilePicture),
                gender = IFNULL(sp_gender, gender)
            WHERE userId = sp_userId
            AND status = 'A';
        
        WHEN 3 THEN
            BEGIN
                DECLARE Attempts INT;
                SELECT failedAttempts INTO Attempts FROM Users WHERE userId = sp_userId;
                
                IF Attempts < 3 THEN
                    UPDATE Users
                    SET failedAttempts = failedAttempts + 1
                    WHERE userId = sp_userId;
                ELSE
                    UPDATE Users
                    SET status = 'D'
                    WHERE userId = sp_userId;
                END IF;
            END;
        
        WHEN 4 THEN
            BEGIN
                DECLARE usernameFound INT DEFAULT 0;
                
                SELECT userId INTO usernameFound
                FROM Users
                WHERE email = sp_email;
                
                IF usernameFound > 0 THEN
                    UPDATE Users
                    SET failedAttempts = 0
                    WHERE userId = usernameFound;

                    SELECT userId, username, fullName, role, email, birthdate, profilePicture, gender, creationDate
                    FROM Users
                    WHERE email = sp_email;
                ELSE
                    SELECT sp_email AS email;
                END IF;
            END;
        
        WHEN 5 THEN
            SELECT username, fullName, email, role, birthdate, password, gender, creationDate
            FROM Users
            WHERE userId = IFNULL(sp_userId, userId)
            AND status = IFNULL(sp_status, status)
            AND username = IFNULL(sp_username, username)
            AND fullName = IFNULL(sp_fullName, fullName)
            AND email = IFNULL(sp_email, email)
            AND role = IFNULL(sp_role, role)
            AND birthdate = IFNULL(sp_birthdate, birthdate);
    END CASE;
END$$

DELIMITER;