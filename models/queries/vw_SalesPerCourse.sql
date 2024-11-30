DROP VIEW IF EXISTS vw_SalesPerCourse;

CREATE VIEW vw_SalesPerCourse AS
SELECT 
    c.courseId,
    c.courseTitle,
    c.creationDate,
    c.categoryId,
    c.deactivationDate,
    c.instructorId,
    COUNT(DISTINCT p.userId) AS totalStudents,
    IFNULL(SUM(p.paymentAmount), 0) AS totalIncome,
    IFNULL(SUM(
        CASE 
            WHEN p.paymentType = 'L' THEN 0
            ELSE p.paymentAmount
        END
        ), 0) AS incomeFromCourses,
    IFNULL(SUM(
        CASE 
            WHEN p.paymentType = 'L' THEN p.paymentAmount
            ELSE 0
        END
        ), 0) AS incomeFromLevels,
    IFNULL(AVG(l.levelsPurchased), 0) AS avgLevelsBought
FROM 
    Courses c
    LEFT JOIN Purchases p ON c.courseId = p.courseId
    LEFT JOIN vw_levelspurchasedbycourseperstudent l ON p.userId = l.userId and p.courseId = l.courseId
GROUP BY 
    c.courseId;