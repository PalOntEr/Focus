-- Muestra la cantidad de niveles que tiene un curso

DROP VIEW IF EXISTS levelsPerCourse;

CREATE VIEW levelsPerCourse AS
SELECT 
    c.courseId AS courseId,
    c.courseTitle AS courseTitle,
    cat.categoryName AS categoryName,
    COUNT(n.levelId) AS totalLevels
FROM 
    Courses c
JOIN 
    Levels n ON c.courseId = n.courseId
JOIN 
    Categories cat ON c.categoryId = cat.categoryId
GROUP BY 
    c.courseId;