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
            INSERT INTO Niveles (creationDate, levelName, levelNumber, levelDescription, levelCost, courseId)
            VALUES (CURRENT_TIMESTAMP, p_levelName, p_levelNumber, p_levelDescription, p_levelCost, p_courseId);
        WHEN 2 THEN -- UPDATE
            UPDATE Niveles
            SET modificationDate = CURRENT_TIMESTAMP,
                levelName = p_levelName,
                levelNumber = p_levelNumber,
                levelDescription = p_levelDescription,
                levelCost = p_levelCost,
                courseId = p_courseId
            WHERE levelId = p_levelId;
        WHEN 3 THEN -- DELETE
            DELETE FROM Niveles
            WHERE levelId = p_levelId;
        WHEN 4 THEN -- SELECT ALL
            SELECT levelId, creationDate, modificationDate, levelName, levelNumber, levelDescription, levelCost, courseId
            FROM Niveles;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT levelId, creationDate, modificationDate, levelName, levelNumber, levelDescription, levelCost, courseId
            FROM Niveles
            WHERE (IFNULL(p_levelId, levelId) = levelId)
              AND (IFNULL(p_creationDate, creationDate) = creationDate)
              AND (IFNULL(p_modificationDate, modificationDate) = modificationDate)
              AND (IFNULL(p_levelName, levelName) = levelName)
              AND (IFNULL(p_levelNumber, levelNumber) = levelNumber)
              AND (IFNULL(p_levelDescription, levelDescription) = levelDescription)
              AND (IFNULL(p_levelCost, levelCost) = levelCost)
              AND (IFNULL(p_courseId, courseId) = courseId);
    END CASE;
END;
DELIMITER;