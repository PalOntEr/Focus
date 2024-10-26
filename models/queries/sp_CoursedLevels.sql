DROP PROCEDURE IF EXISTS sp_CoursedLevels;

DELIMITER //
CREATE PROCEDURE sp_CoursedLevels(
    IN p_Opc INT,
    IN p_levelId INT,
    IN p_userId INT
)
BEGIN
    CASE p_Opc
        WHEN 1 THEN -- INSERT
            INSERT INTO nivelesCursados (levelId, userId)
            VALUES (p_levelId, p_userId);
        WHEN 2 THEN -- UPDATE Los niveles cursados no pueden ser modificados
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Los niveles cursados no pueden ser modificados';
        WHEN 3 THEN -- DELETE
            DELETE FROM nivelesCursados
            WHERE levelId = p_levelId AND userId = p_userId;
        WHEN 4 THEN -- SELECT ALL
            SELECT levelId, userId
            FROM nivelesCursados;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT levelId, userId
            FROM nivelesCursados
            WHERE (IFNULL(p_levelId, levelId) = levelId)
              AND (IFNULL(p_userId, userId) = userId);
    END CASE;
END;
DELIMITER;