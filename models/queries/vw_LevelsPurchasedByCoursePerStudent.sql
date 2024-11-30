DROP VIEW IF EXISTS vw_LevelsPurchasedByCoursePerStudent;

CREATE VIEW vw_LevelsPurchasedByCoursePerStudent AS
SELECT 
    c.courseId,
    c.courseTitle,
    c.creationDate,
    c.categoryId,
    c.deactivationDate,
    c.instructorId,
    u.userId,
    COUNT(c.courseId) as levelsPurchased
FROM 
    Levels L
    JOIN purchasedlevels pl ON L.levelId = pl.levelId
    JOIN users u ON pl.userId = u.userId
    JOIN courses c ON L.courseId = c.courseId
GROUP BY
    c.courseId, c.courseTitle, c.deactivationDate, c.instructorId, u.userId;