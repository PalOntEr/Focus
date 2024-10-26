DELIMITER $$

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
                    WHERE ((senderId = p_senderId AND receiverId = p_receiverId) OR (senderId = p_receiverId AND receiverId = p_senderId));
        END CASE;

END$$

DELIMITER ;