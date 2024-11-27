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
            SET courseDescription = p_courseDescription,
                courseTitle = p_courseTitle,
                modificationDate = CURRENT_TIMESTAMP,
                courseImage = p_courseImage,
                categoryId = p_categoryId,
                instructorId = p_instructorId,
                coursePrice = p_coursePrice
            WHERE courseId = p_courseId;
        WHEN 3 THEN -- DELETE
            UPDATE Courses
            SET deactivationDate = CURRENT_TIMESTAMP
            WHERE courseId = p_courseId;
        WHEN 4 THEN -- SELECT ALL
            SELECT courseId, creationDate, modificationDate, deactivationDate, courseTitle, categoryId, instructorId, coursePrice, courseDescription, courseImage
            FROM Courses;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT courseId, creationDate, modificationDate, deactivationDate, courseTitle, categoryId, instructorId, coursePrice, courseDescription, courseImage
            FROM Courses
            WHERE (p_courseId IS NULL OR courseId = p_courseId)
                AND (p_categoryId IS NULL OR categoryId = p_categoryId)
                AND (p_coursePrice IS NULL OR coursePrice = p_coursePrice)
                AND (p_courseTitle IS NULL OR courseTitle LIKE CONCAT('%', p_courseTitle, '%'))
                AND (p_courseDescription IS NULL OR courseDescription LIKE CONCAT('%', p_courseDescription, '%'))
                AND (p_instructorId IS NULL OR instructorId = p_instructorId)
                AND (p_deactivationDate IS NULL OR deactivationDate = p_deactivationDate);
    END CASE;
END

DELIMITER ;
