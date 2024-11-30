DROP VIEW IF EXISTS vw_StudentReport;

CREATE VIEW vw_StudentReport AS
SELECT
    u.*,
    COUNT(k.userId) AS enrolledCourses,
    CAST(IFNULL(COUNT(CASE WHEN k.completionDate IS NOT NULL THEN 1 END) / COUNT(k.userId), 0) AS DECIMAL(10, 2)) AS completedCourses
FROM users u
LEFT JOIN kardex k ON u.userId = k.userId
GROUP BY u.userId;
