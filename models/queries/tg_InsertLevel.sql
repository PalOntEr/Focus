DELIMITER //
CREATE TRIGGER tg_InsertLevel
AFTER INSERT ON Levels
FOR EACH ROW
BEGIN
    INSERT INTO PurchasedLevels (levelId, userId, completed)
    SELECT NEW.levelId, p.userId, FALSE
    FROM Purchases p
    WHERE p.courseId = NEW.courseId AND p.paymentType = 'C';
END;

//

DELIMITER ;