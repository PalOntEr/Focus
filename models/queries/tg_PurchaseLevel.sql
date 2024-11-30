DELIMITER //
CREATE TRIGGER tg_PurchaseLevel
AFTER INSERT ON Purchases
FOR EACH ROW
BEGIN
    IF NEW.paymentType = 'C' THEN
        INSERT INTO PurchasedLevels (levelId, userId, completed)
        SELECT levelId, NEW.userId, FALSE
        FROM Levels
        WHERE courseId = NEW.courseId;
    ELSEIF NEW.paymentType = 'L' THEN
        INSERT INTO PurchasedLevels (levelId, userId, completed)
        VALUES (NEW.levelId, NEW.userId, FALSE);
    END IF;
    
    
    IF NOT EXISTS (SELECT 1 FROM Kardex WHERE userId = NEW.userId AND courseId = NEW.courseId) THEN
        INSERT INTO Kardex (userId, courseId)
        VALUES (NEW.userId, NEW.courseId);
    END IF;
END;

//

DELIMITER ;