DROP PROCEDURE IF EXISTS sp_Kardex;

DELIMITER //
CREATE PROCEDURE sp_Kardex(
    IN p_Opc INT,
    IN p_startDate DATETIME,
    IN p_accessDate DATETIME,
    IN p_completionDate DATETIME,
    IN p_userId INT,
    IN p_courseId INT,
    IN p_paymentMethod VARCHAR(20),
    IN p_paymentType CHAR
)
BEGIN
    CASE p_Opc
        WHEN 1 THEN -- INSERT
            INSERT INTO Kardex (accessDate, completionDate, userId, courseId, paymentMethod, paymentType)
            VALUES (p_accessDate, p_completionDate, p_userId, p_courseId, p_paymentMethod, p_paymentType);
        WHEN 2 THEN -- UPDATE
            UPDATE Kardex
            SET startDate = p_startDate,
                accessDate = p_accessDate,
                completionDate = p_completionDate,
                paymentMethod = p_paymentMethod,
                paymentType = p_paymentType
            WHERE userId = p_userId AND courseId = p_courseId;
        WHEN 3 THEN -- FINISH Actualiza la fecha de finalizacion a la actual
            UPDATE Kardex
            SET completionDate = CURRENT_TIMESTAMP
            WHERE userId = p_userId AND courseId = p_courseId;
        WHEN 4 THEN -- SELECT ALL
            SELECT startDate, accessDate, completionDate, userId, courseId, paymentMethod, paymentType
            FROM Kardex;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT startDate, accessDate, completionDate, userId, courseId, paymentMethod, paymentType
            FROM Kardex
            WHERE (IFNULL(p_startDate, startDate) = startDate)
              AND (IFNULL(p_accessDate, accessDate) = accessDate)
              AND (IFNULL(p_completionDate, completionDate) = completionDate)
              AND (IFNULL(p_userId, userId) = userId)
              AND (IFNULL(p_courseId, courseId) = courseId)
              AND (IFNULL(p_paymentMethod, paymentMethod) = paymentMethod)
              AND (IFNULL(p_paymentType, paymentType) = paymentType);
    END CASE;
END;
DELIMITER;