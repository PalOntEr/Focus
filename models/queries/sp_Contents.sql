DELIMITER $$

CREATE PROCEDURE sp_Contents(
    IN p_Opc INT,
    IN p_contentId INT,
    IN p_file VARCHAR(255),
    IN p_mimeType VARCHAR(128),
    IN p_levelId INT
)
BEGIN

    CASE p_Opc
        WHEN 1 THEN INSERT INTO Contents(file, mimeType, levelId)
                    VALUES (p_file, p_mimeType, p_levelId);
        WHEN 2 THEN UPDATE Contents
                    SET file = p_file,
                        mimeType = p_mimeType,
                        levelId = p_levelId
                    WHERE contentId = p_contentId;
        WHEN 3 THEN SELECT contentId, file, mimeType, levelId
                    FROM Contents
                    WHERE contentId = p_contentId;
        WHEN 4 THEN SELECT contentId, file, mimeType, levelId
                    FROM Contents
                    WHERE levelId = p_levelId;


        END CASE;

END$$

DELIMITER ;