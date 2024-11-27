DELIMITER $$

DROP PROCEDURE IF EXISTS sp_Messages$$

CREATE PROCEDURE sp_Messages(
    IN p_Opc INT,
    IN p_messageId INT,
    IN p_senderId INT,
    IN p_receiverId INT,
    IN p_message TEXT
)
BEGIN

    CASE p_Opc
        WHEN 1 THEN INSERT INTO messages(senderId, receiverId, message)
                    VALUES (p_senderId, p_receiverId, p_message);
        WHEN 2 THEN SELECT *
                FROM messages
                WHERE (IFNULL(p_senderId, senderId) = senderId)
                  AND (IFNULL(p_receiverId, receiverId) = receiverId);
        END CASE;

END$$

DELIMITER ;