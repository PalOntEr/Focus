DROP PROCEDURE IF EXISTS sp_Levels;

DELIMITER //
CREATE PROCEDURE sp_Levels(
    IN p_Opc INT,
    IN p_levelId INT,
    IN p_creationDate DATETIME,
    IN p_modificationDate DATETIME,
    IN p_levelName VARCHAR(50),
    IN p_levelNumber INT,
    IN p_levelDescription TEXT,
    IN p_levelCost DECIMAL(10,2),
    IN p_courseId INT,
    IN p_active BOOLEAN
)
BEGIN
    CASE p_Opc
        WHEN 1 THEN -- INSERT
            INSERT INTO levels (creationDate, levelName, levelNumber, levelDescription, levelCost, courseId)
            VALUES (CURRENT_TIMESTAMP, p_levelName, p_levelNumber, p_levelDescription, p_levelCost, p_courseId);
        WHEN 2 THEN -- UPDATE
            UPDATE levels
            SET modificationDate = CURRENT_TIMESTAMP,
                levelName = p_levelName,
                levelNumber = p_levelNumber,
                levelDescription = p_levelDescription,
                levelCost = p_levelCost,
                courseId = p_courseId
            WHERE levelId = p_levelId;
        WHEN 3 THEN -- DELETE
            UPDATE levels
            SET active = FALSE,
            `levelNumber` = 0
            WHERE levelId = p_levelId;
        WHEN 4 THEN -- SELECT ALL
            SELECT levelId, creationDate, modificationDate, levelName, levelNumber, levelDescription, levelCost, courseId
            FROM levels;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT levelId, creationDate, modificationDate, levelName, levelNumber, levelDescription, levelCost, courseId
            FROM Levels
            WHERE (p_levelId IS NULL OR levelId = p_levelId)
                AND (p_levelName IS NULL OR levelName LIKE CONCAT('%', p_levelName, '%'))
                AND (p_levelNumber IS NULL OR levelNumber = p_levelNumber)
                AND (p_levelDescription IS NULL OR levelDescription LIKE CONCAT('%', p_levelDescription, '%'))
                AND (p_levelCost IS NULL OR levelCost = p_levelCost)
                AND (p_courseId IS NULL OR courseId = p_courseId)
                AND (p_creationDate IS NULL OR DATEDIFF(creationDate, p_creationDate) >= 0)
                AND (p_modificationDate IS NULL OR DATEDIFF(modificationDate, p_modificationDate) <= 0)
                AND (p_active IS NULL OR p_active = active);
    END CASE;
END;
DELIMITER;