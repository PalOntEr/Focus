DROP PROCEDURE IF EXISTS sp_Purchase;

DELIMITER //
CREATE PROCEDURE sp_Purchase
(
    IN p_Opc INT,
    IN p_purchaseId INT,
    IN p_purchaseDate DATETIME,
    IN p_modificationDate DATETIME,
    IN p_userId INT,
    IN p_courseId INT,
    IN p_levelId INT,
    IN p_paymentMethod VARCHAR(20),
    IN p_paymentType CHAR,
    IN p_paymentAmount DECIMAL(10, 2)
)
BEGIN
    CASE p_Opc
        WHEN 1 THEN -- INSERT
            INSERT INTO Purchases(purchaseDate, userId, courseId, levelId, paymentMethod, paymentType, paymentAmount)
            VALUES(p_purchaseDate, p_userId, p_courseId, p_levelId, p_paymentMethod, p_paymentType, p_paymentAmount);
        WHEN 2 THEN -- UPDATE
            UPDATE Purchases
            SET purchaseDate = p_purchaseDate,
                userId = p_userId,
                courseId = p_courseId,
                levelId = p_levelId,
                paymentMethod = p_paymentMethod,
                paymentType = p_paymentType,
                paymentAmount = p_paymentAmount
            WHERE purchaseId = p_purchaseId;
        WHEN 3 THEN -- DELETE
            DELETE FROM Purchases
            WHERE purchaseId = p_purchaseId;
        WHEN 4 THEN -- SELECT ALL
            SELECT purchaseId, purchaseDate, userId, courseId, levelId, paymentMethod, paymentType, paymentAmount
            FROM Purchases;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT purchaseId, purchaseDate, userId, courseId, levelId, paymentMethod, paymentType, paymentAmount
            FROM Purchases
            WHERE (p_purchaseId IS NULL OR purchaseId = p_purchaseId)
                AND (p_userId IS NULL OR userId = p_userId)
                AND (p_courseId IS NULL OR courseId = p_courseId)
                AND (p_paymentMethod IS NULL OR paymentMethod LIKE CONCAT('%', p_paymentMethod, '%'))
                AND (p_paymentType IS NULL OR paymentType = p_paymentType)
                AND (p_paymentAmount IS NULL OR paymentAmount = p_paymentAmount)
                AND (p_purchaseDate IS NULL OR DATEDIFF(purchaseDate, p_purchaseDate) = 0);
        WHEN 6 THEN -- SELECT PURCHASE REPORT WITH FILTER
            SELECT *
            FROM vw_purchasereport
            WHERE (p_purchaseId IS NULL OR purchaseId = p_purchaseId)
                AND (p_userId IS NULL OR userId = p_userId)
                AND (p_courseId IS NULL OR courseId = p_courseId)
                AND (p_paymentMethod IS NULL OR paymentMethod LIKE CONCAT('%', p_paymentMethod, '%'))
                AND (p_paymentType IS NULL OR paymentType = p_paymentType)
                AND (p_paymentAmount IS NULL OR paymentAmount = p_paymentAmount)
                AND (p_purchaseDate IS NULL OR DATEDIFF(purchaseDate, p_purchaseDate) >= 0)
                AND (p_modificationDate IS NULL OR DATEDIFF(purchaseDate, p_modificationDate) <= 0);
    END CASE;
END

DELIMITER ;