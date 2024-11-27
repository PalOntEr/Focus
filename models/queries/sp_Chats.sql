-- Ejecutar primero el archivo: models/queries/vw_Chats.sql

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_Chats$$

CREATE PROCEDURE sp_Chats(
    IN p_Opc INT,
    IN p_senderId INT,
    IN p_receiverId INT
)
BEGIN

    CASE p_Opc
        WHEN 1 THEN 
            SELECT * 
            FROM vw_Chats 
            WHERE (IFNULL(p_senderId, senderId) = senderId) 
              AND (IFNULL(p_receiverId, receiverId) = receiverId);
    END CASE;

END$$

DELIMITER ;