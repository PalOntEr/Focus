-- Ejecutar primero la vista de NivelesPorCurso.sql esta vista depende de ella
-- Muestra la cantidad de niveles que ha cursado un estudiante y el porcentaje de compleción

DROP VIEW IF EXISTS LevelsCoursedPerStudent;

CREATE VIEW LevelsCoursedPerStudent AS
SELECT
    u.userId AS userId,
    u.fullName AS fullName,
    c.courseId AS courseId,
    c.courseTitle AS courseTitle,
    COUNT(nc.levelId) AS totalCoursedLevels,
    CAST((COUNT(nc.levelId) / (SELECT totalLevels FROM levelsPerCourse n WHERE n.courseId = c.courseId)) * 100 AS DECIMAL(27,2)) AS percentageCompleted
FROM
    PurchasedLevels nc
JOIN
    Levels n ON nc.levelId = n.levelId
JOIN
    Courses c ON n.courseId = c.courseId
JOIN
    Users u ON nc.userId = u.userId
WHERE 
    u.role = 'S'
GROUP BY
    c.courseId, u.userId;