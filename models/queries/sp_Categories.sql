DROP PROCEDURE IF EXISTS sp_Categories;

DELIMITER / /

CREATE PROCEDURE sp_Categories(
    IN p_Opc INT,
    IN p_categoryId INT,
    IN p_categoryName VARCHAR(50),
    IN p_categoryDescription TEXT,
    IN p_creatorId INT
)

BEGIN
    CASE p_Opc
        WHEN 1 THEN -- INSERT
            INSERT INTO Categories (categoryName, categoryDescription, creatorId)
            VALUES (p_categoryName, p_categoryDescription, p_creatorId);
        WHEN 2 THEN -- UPDATE
            UPDATE Categories
            SET categoryName = p_categoryName,
                categoryDescription = p_categoryDescription,
                modificationDate = CURRENT_TIMESTAMP
            WHERE categoryId = p_categoryId;
        WHEN 3 THEN -- DELETE
        BEGIN
            DECLARE Used INT DEFAULT 0;
            
            SELECT COUNT(categoryId) INTO Used FROM Courses
            WHERE `categoryId` = p_categoryId;

            IF Used = 0 THEN 
                UPDATE Categories
                SET deactivationDate = CURRENT_TIMESTAMP
                WHERE categoryId = p_categoryId;
            ELSE 
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT= Used;
            END IF;
        END;
        WHEN 4 THEN -- SELECT ALL
            SELECT categoryId, creationDate, modificationDate, deactivationDate, categoryName, categoryDescription, creatorId 
            FROM Categories;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT categoryId, creationDate, modificationDate, deactivationDate, categoryName, categoryDescription, creatorId 
            FROM Categories
            WHERE (IFNULL(p_categoryId, categoryId) = categoryId)
              AND (IFNULL(p_categoryName, categoryName) = categoryName)
              AND (IFNULL(p_categoryDescription, categoryDescription) = categoryDescription)
              AND (IFNULL(p_creatorId, creatorId) = creatorId)
              AND ISNULL(`deactivationDate`);
        WHEN 6 THEN -- SELECT WITH NAME OF CREATOR
        SELECT `categoryId`,`categoryName`, `categoryDescription`, `fullName` AS User, `creationDate` AS Created FROM CategoryInfo
        WHERE ISNULL(`deactivationDate`);
    END CASE;
END;

DELIMITER //;