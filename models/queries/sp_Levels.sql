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
    IN p_courseId INT
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
            DELETE FROM levels
            WHERE levelId = p_levelId;
        WHEN 4 THEN -- SELECT ALL
            SELECT levelId, creationDate, modificationDate, levelName, levelNumber, levelDescription, levelCost, courseId
            FROM levels;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT levelId, creationDate, modificationDate, levelName, levelNumber, levelDescription, levelCost, courseId
            FROM Levels
WHERE (p_levelId IS NULL OR p_levelId = levelId)
  AND (p_creationDate IS NULL OR p_creationDate = creationDate)
  AND (p_modificationDate IS NULL OR p_modificationDate = modificationDate)
  AND (p_levelName IS NULL OR p_levelName = levelName)
  AND (p_levelNumber IS NULL OR p_levelNumber = levelNumber)
  AND (p_levelDescription IS NULL OR p_levelDescription = levelDescription)
  AND (p_levelCost IS NULL OR p_levelCost = levelCost)
  AND (p_courseId IS NULL OR p_courseId = courseId);
    END CASE;
END;
DELIMITER;