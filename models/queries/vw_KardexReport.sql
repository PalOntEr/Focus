DROP VIEW IF EXISTS vw_KardexReport;

CREATE VIEW vw_KardexReport AS  
SELECT 
    l.userId,
    c.courseId,
    c.courseTitle,
    c.categoryId,
    c.deactivationDate,
    l.percentageCompleted,
    k.startDate,
    IFNULL(k.completionDate, "Not completed") as endDate,
    IFNULL(k.accessDate, "Has not been accessed") as accessDate,
    CASE 
        WHEN l.percentageCompleted = 100 THEN TRUE 
        ELSE FALSE 
    END AS isCompleted
FROM
    kardex k
    LEFT JOIN Courses c ON k.courseId = c.courseId
    JOIN levelscoursedperstudent l ON k.courseId = l.courseId AND k.userId = l.userId
