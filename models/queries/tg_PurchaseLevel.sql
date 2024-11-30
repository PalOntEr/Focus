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

DROP TRIGGER IF EXISTS tg_UpdateKardex; 
DELIMITER //
CREATE TRIGGER tg_UpdateKardex
AFTER UPDATE ON PurchasedLevels
FOR EACH ROW
BEGIN
    DECLARE T_totalLevels INT;
    DECLARE T_completedLevels INT;
    DECLARE PlcourseId INT;

    SELECT courseId INTO PlcourseId
    FROM Levels
    WHERE levelId = NEW.levelId;

    SELECT totalLevels INTO T_totalLevels
    FROM levelsPerCourse WHERE courseId = PlcourseId;

    SELECT totalCoursedLevels INTO T_completedLevels
    FROM LevelsCoursedPerStudent
    WHERE userId = NEW.userId AND courseId = PlcourseId;

    IF T_totalLevels <= T_completedLevels THEN
        UPDATE Kardex
        SET completionDate = NOW(), accessDate = NOW()
        WHERE userId = NEW.userId AND courseId = PlcourseId;
    ELSE
        UPDATE Kardex
        SET accessDate = NOW()
        WHERE userId = NEW.userId AND courseId = PlcourseId;
    END IF;

END;
//

DELIMITER ;