DROP PROCEDURE IF EXISTS sp_PurchasedLevels;

DELIMITER //
CREATE PROCEDURE sp_PurchasedLevels(
    IN p_Opc INT,
    IN p_levelId INT,
    IN p_userId INT,
    IN p_Completed INT
)
BEGIN
    CASE p_Opc
        WHEN 1 THEN -- UPDATE Los niveles cursados no pueden ser modificados
        Update purchasedlevels
        SET completed = p_Completed
        WHERE `levelId` = p_levelId AND `userId` = p_userId;
        WHEN 2 THEN -- DELETE
            DELETE FROM purchasedlevels
            WHERE levelId = p_levelId AND userId = p_userId;
        WHEN 3 THEN -- SELECT ALL
            SELECT levelId, userId
            FROM purchasedlevels;
        WHEN 4 THEN -- SELECT WITH FILTER
            SELECT levelId, userId,completed
            FROM purchasedlevels
            WHERE (p_levelId IS NULL OR p_levelId = levelId)
            AND (p_userId IS NULL OR p_userId = userId)
            AND (p_Completed IS NULL OR p_Completed = completed);
    END CASE;
END;
DELIMITER;