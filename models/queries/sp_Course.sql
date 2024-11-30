DROP PROCEDURE IF EXISTS sp_Course;

DELIMITER //
CREATE PROCEDURE sp_Course
(
	IN p_Opc INT,
    IN p_courseId INT,
    IN p_creationDate DATETIME,
    IN p_modificationDate DATETIME,
    IN p_deactivationDate DATETIME,
    IN p_courseDescription TEXT,
    IN p_courseTitle VARCHAR(50),
    IN p_courseImage LONGBLOB,
    IN p_categoryId INT,
    IN p_instructorId INT,
    IN p_coursePrice DECIMAL (10,2)
)
BEGIN
    CASE p_Opc
        WHEN 1 THEN -- INSERT
            INSERT INTO Courses(courseDescription,courseTitle,courseImage,categoryId,instructorId,coursePrice)
            VALUES(p_courseDescription,p_courseTitle,p_courseImage,p_categoryId,p_instructorId,p_coursePrice);
        WHEN 2 THEN -- UPDATE
UPDATE Courses
SET 
    courseDescription = IF(p_courseDescription IS NULL, courseDescription, p_courseDescription),
    courseTitle = IF(p_courseTitle IS NULL, courseTitle, p_courseTitle),
    modificationDate = CURRENT_TIMESTAMP,
    courseImage = IF(p_courseImage IS NULL, courseImage, p_courseImage),
    categoryId = IF(p_categoryId IS NULL, categoryId, p_categoryId),
    instructorId = IF(p_instructorId IS NULL, instructorId, p_instructorId),
    `deactivationDate` = p_deactivationDate,
    coursePrice = p_coursePrice
WHERE courseId = p_courseId;
        WHEN 3 THEN -- DELETE
            UPDATE Courses
            SET deactivationDate = CURRENT_TIMESTAMP
            WHERE courseId = p_courseId;
        WHEN 4 THEN -- SELECT ALL
            SELECT courseId, creationDate, modificationDate, deactivationDate, courseTitle, categoryId, instructorId, coursePrice, courseDescription, courseImage, averageRating
            FROM vw_courserating;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT courseId, creationDate, modificationDate, deactivationDate, courseTitle, categoryId, instructorId, coursePrice, courseDescription, courseImage, averageRating
            FROM vw_courserating
            WHERE (p_courseId IS NULL OR courseId = p_courseId)
                AND (p_categoryId IS NULL OR categoryId = p_categoryId)
                AND (p_coursePrice IS NULL OR coursePrice = p_coursePrice)
                AND (p_courseTitle IS NULL OR courseTitle LIKE CONCAT('%', p_courseTitle, '%'))
                AND (p_courseDescription IS NULL OR courseDescription LIKE CONCAT('%', p_courseDescription, '%'))
                AND (p_instructorId IS NULL OR instructorId = p_instructorId)
                AND (p_creationDate IS NULL OR DATEDIFF(creationDate, p_creationDate) >= 0)
                AND (p_modificationDate IS NULL OR DATEDIFF(creationDate, p_modificationDate) <= 0)
                AND (p_deactivationDate IS NULL OR DATEDIFF(deactivationDate, p_deactivationDate) <= 0);
        WHEN 6 THEN -- SELECT TOP 10 SELLERS
            SELECT c.courseId, c.creationDate, c.modificationDate, c.deactivationDate, c.courseTitle, c.categoryId, c.instructorId, c.coursePrice, c.courseDescription, c.courseImage, c.averageRating
            FROM vw_salespercourse spc
            JOIN vw_courserating c ON spc.courseId = c.courseId
            ORDER BY totalIncome DESC
            LIMIT 10;
        WHEN 7 THEN -- SELECT TOP 10 RATED
            SELECT c.courseId, c.creationDate, c.modificationDate, c.deactivationDate, c.courseTitle, c.categoryId, c.instructorId, c.coursePrice, c.courseDescription, c.courseImage, c.averageRating
            FROM vw_courserating c
            ORDER BY averageRating DESC
            LIMIT 10;
        WHEN 8 THEN -- SELECT TOP 10 RATED BY SPECIFIC USER
            SELECT cru.courseId, cru.creationDate, cru.modificationDate, cru.deactivationDate, cru.courseTitle, cru.categoryId, cru.instructorId, cru.coursePrice, cru.courseDescription, cru.courseImage, cru.rating, cru.userId
            FROM vw_coursesrecommendedbyusers cru
            WHERE cru.userId = p_instructorId
            ORDER BY cru.rating DESC
            LIMIT 10;
    END CASE;
END

DELIMITER ;
