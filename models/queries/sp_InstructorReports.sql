DROP PROCEDURE IF EXISTS sp_InstructorReports;

DELIMITER $$

CREATE PROCEDURE sp_InstructorReports
(
    IN Op INT,
    IN sp_instructorId INT,
    IN sp_creationDate DATETIME,
    IN sp_modificationDate DATETIME,
    IN sp_categoryId INT,
    IN sp_courseId INT
)
BEGIN
    CASE Op
        WHEN 1 THEN
            SELECT 
                courseId,
                courseTitle,
                creationDate,
                categoryId,
                deactivationDate,
                instructorId,
                totalStudents,
                incomeFromCourses,
                incomeFromLevels,
                totalIncome,
                avgLevelsBought
            FROM vw_SalesPerCourse
                WHERE
                    instructorId = IFNULL(sp_instructorId, instructorId)
                    AND courseId = IFNULL(sp_courseId, courseId)
                    AND (sp_creationDate IS NULL OR DATEDIFF(creationDate, sp_creationDate) >= 0)
                    AND (sp_modificationDate IS NULL OR DATEDIFF(creationDate, sp_modificationDate) <= 0)
                    AND categoryId = IFNULL(sp_categoryId, categoryId);
    END CASE;
END$$

DELIMITER;