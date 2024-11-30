DROP PROCEDURE IF EXISTS sp_Comments;

DELIMITER //
CREATE PROCEDURE sp_Comments(
    IN p_Opc INT,
    IN p_commentId INT,
    IN p_creationDate DATETIME,
    IN p_deactivationDate DATETIME,
    IN p_comment TEXT,
    IN p_userId INT,
    IN p_courseId INT,
    IN p_rating INT
)
BEGIN
    CASE p_Opc
        WHEN 1 THEN -- INSERT
            INSERT INTO Comments (creationDate, comment, userId, courseId, rating)
            VALUES (CURRENT_TIMESTAMP, p_comment, p_userId, p_courseId, p_rating);
        WHEN 2 THEN -- UPDATE Los comentarios no pueden ser modificados
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Los comentarios no pueden ser modificados';
        WHEN 3 THEN -- DELETE idUsuario es el usuario Admin que eliminó el comentario y el contenidoComentario es la razón de eliminación
            INSERT INTO DeletedComments (adminUserId, commentId, deletionReason)
            VALUES (p_userId, p_commentId, p_comment);
            UPDATE Comments
            SET deactivationDate = CURRENT_TIMESTAMP
            WHERE commentId = p_commentId;
        WHEN 4 THEN -- SELECT ALL
            SELECT commentId, creationDate,deactivationDate, comment, userId, courseId, rating
            FROM Comments;
        WHEN 5 THEN -- SELECT WITH FILTER
            SELECT commentId, creationDate,deactivationDate, comment, userId, courseId, rating
            FROM Comments
            WHERE 
               (p_commentId IS NULL OR p_commentId = commentId)
    AND (p_creationDate IS NULL OR p_creationDate = creationDate)
    AND (p_deactivationDate IS NULL OR p_deactivationDate = deactivationDate)
    AND (p_comment IS NULL OR p_comment = comment)
    AND (p_userId IS NULL OR p_userId = userId)
    AND (p_courseId IS NULL OR p_courseId = courseId)
    AND (p_rating IS NULL OR p_rating = rating);
        WHEN 6 THEN
            SELECT commentId, deletionReason
            FROM deletedcomments;
    END CASE;
END;
DELIMITER;