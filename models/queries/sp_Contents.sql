DROP PROCEDURE IF EXISTS sp_Contents;

DELIMITER $$

CREATE PROCEDURE sp_Contents(
    IN p_Opc INT,
    IN p_contentId INT,
    IN p_file LONGBLOB,
    IN p_name VARCHAR(128),
    IN p_mimeType VARCHAR(128),
    IN p_levelId INT
)
BEGIN

    CASE p_Opc
        WHEN 1 THEN INSERT INTO Contents(file,name, mimeType, levelId)
                    VALUES (p_file,p_name, p_mimeType, p_levelId);
        WHEN 2 THEN UPDATE Contents
                    SET file = p_file,
                        mimeType = p_mimeType,
                        name = p_name,
                        levelId = p_levelId
                    WHERE contentId = p_contentId;
        WHEN 3 THEN SELECT contentId, file,name, mimeType, levelId
                    FROM Contents
                    WHERE contentId = p_contentId;
        WHEN 4 THEN SELECT contentId, file,name, mimeType, levelId
                    FROM Contents
                    WHERE levelId = p_levelId;
        WHEN 5 THEN UPDATE Contents
                    SET file = p_file,
                        mimeType = p_mimeType,
                        name = p_name
                    WHERE levelId = p_levelId;
    WHEN 6 THEN DELETE FROM contents
    WHERE `levelId` = p_levelId
    AND mimeType = p_mimeType;
        END CASE;

END$$

DELIMITER ;