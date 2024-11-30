-- Ejecutar primero la vista de NivelesPorCurso.sql esta vista depende de ella
-- Muestra la cantidad de niveles que ha cursado un estudiante y el porcentaje de compleción

DROP VIEW IF EXISTS LevelsCoursedPerStudent;

CREATE VIEW LevelsCoursedPerStudent AS
SELECT
    u.userId AS userId,
    u.fullName AS fullName,
    c.courseId AS courseId,
    c.courseTitle AS courseTitle,
    COUNT(CASE WHEN nc.completed = TRUE THEN 1 ELSE NULL END) AS totalCoursedLevels,
    CAST((COUNT(CASE WHEN nc.completed = TRUE THEN 1 ELSE NULL END) /  lp.totalLevels) * 100 AS DECIMAL(27,2)) AS percentageCompleted
FROM
    PurchasedLevels nc
JOIN
    Levels n ON nc.levelId = n.levelId
JOIN
    Courses c ON n.courseId = c.courseId
JOIN
    Users u ON nc.userId = u.userId
JOIN
    levelsPerCourse lp ON c.courseId = lp.courseId
GROUP BY
    c.courseId, u.userId;