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
            UPDATE Categorias
            SET categoryName = p_categoryName,
                categoryDescription = p_categoryDescription,
                modificationDate = CURRENT_TIMESTAMP
            WHERE categoryId = p_categoryId;
        WHEN 3 THEN -- DELETE
            UPDATE Categorias
            SET deactivationDate = CURRENT_TIMESTAMP
            WHERE categoryId = p_categoryId;
        WHEN 4 THEN -- SELECT ALL
            SELECT categoryId, creationDate, modificationDate, deactivationDate, categoryName, categoryDescription, creatorId 
            FROM Categories;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT categoryId, creationDate, modificationDate, deactivationDate, categoryName, categoryDescription, creatorId 
            FROM Categories
            WHERE (IFNULL(p_categoryId, categoryId) = categoryId)
              AND (IFNULL(p_categoryName, categoryName) = categoryName)
              AND (IFNULL(p_categoryDescription, categoryDescription) = categoryDescription)
              AND (IFNULL(p_creatorId, creatorId) = creatorId);
        WHEN 6 THEN -- SELECT WITH NAME OF CREATOR
        SELECT `categoryName`, `categoryDescription`, `fullName` AS User, `creationDate` AS Created FROM CategoryInfo;
    END CASE;
END;

DELIMITER //;