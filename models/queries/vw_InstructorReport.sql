DROP VIEW IF EXISTS vw_InstructorReport;

CREATE VIEW vw_InstructorReport AS
SELECT
    u.*,
    COUNT(DISTINCT c.courseId) AS createdCourses,
    SUM(p.paymentAmount) AS earnings
FROM users u
    LEFT JOIN Courses c on u.userId = c.instructorId
    LEFT JOIN Purchases p ON c.courseId = p.courseId
    LEFT JOIN vw_levelspurchasedbycourseperstudent l ON p.userId = l.userId and p.courseId = l.courseId
GROUP BY u.userId;
