DROP VIEW IF EXISTS vw_CoursesRecommendedByUsers;

CREATE VIEW vw_CoursesRecommendedByUsers AS
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
    co.userId,
    co.rating
FROM 
    Courses c
JOIN 
    Comments co ON c.courseId = co.courseId
WHERE 
    co.rating >= 4;