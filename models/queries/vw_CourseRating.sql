DROP VIEW IF EXISTS vw_CourseRating;

CREATE VIEW vw_CourseRating AS
SELECT 
    c.courseId,
    c.creationDate,
    c.modificationDate,
    c.deactivationDate,
    c.courseDescription,
    c.courseTitle,
    c.courseImage,
    c.categoryId,
    c.instructorId,
    c.coursePrice,
    CAST(IFNULL(AVG(co.rating), 0) AS DECIMAL(14,0)) AS averageRating
FROM 
    Courses c
LEFT JOIN 
    Comments co ON c.courseId = co.courseId
GROUP BY 
    c.courseId;