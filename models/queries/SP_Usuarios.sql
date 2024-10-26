USE db_bdm;

DROP PROCEDURE IF EXISTS sp_Usuarios;

DELIMITER $$

CREATE PROCEDURE sp_Usuarios(
    IN p_Opc INT,
    IN p_idUsuario INT,
    IN p_correoElectronico VARCHAR(50),
    IN p_contrasena VARCHAR(95),
    IN p_nombreUsuario VARCHAR(20),
    IN p_nombreCompleto VARCHAR(75),
    IN p_fechaNacimiento DATE,
    IN p_fotoPerfil LONGBLOB,
    IN p_genero CHAR,
    IN p_rol CHAR
)
BEGIN
    DECLARE numIntentosActual INT;

CASE p_OPC
        WHEN 1 THEN INSERT INTO Usuarios(correoElectronico, contrasena, nombreUsuario, nombreCompleto, fechaNacimiento,
                                         fotoPerfil, genero, rol)
                    VALUES (p_correoElectronico, p_contrasena, p_nombreUsuario, p_nombreCompleto, p_fechaNacimiento,
                            p_fotoPerfil, p_genero, p_rol);
WHEN 2 THEN UPDATE Usuarios
            SET correoElectronico = p_correoElectronico,
                contrasena        = p_contrasena,
                nombreUsuario     = p_nombreUsuario,
                nombreCompleto    = p_nombreCompleto,
                fechaNacimiento   = p_fechaNacimiento,
                fotoPerfil        = p_fotoPerfil,
                genero            = p_genero,
                fechaModificacion = CURRENT_TIMESTAMP
            WHERE idUsuario = p_idUsuario
              AND status = 'A';
WHEN 3 THEN
SELECT numIntentos INTO numIntentosActual FROM Usuarios WHERE correoElectronico = p_correoElectronico;
IF numIntentosActual < 3 THEN
UPDATE Usuarios
SET numIntentos = numIntentosActual + 1
WHERE correoElectronico = p_correoElectronico;
ELSE
UPDATE Usuarios
SET status = 'D'
WHERE correoElectronico = p_correoElectronico;
END IF;
WHEN 4 THEN SELECT idUsuario,
                   fotoPerfil,
                   nombreUsuario,
                   nombreCompleto,
                   correoElectronico,
                   rol,
                   genero,
                   fechaNacimiento,
                   contrasena
            FROM Usuarios
            WHERE correoElectronico = p_correoElectronico
              AND status = 'A';
WHEN 5 THEN SELECT COUNT(*) AS existe
            FROM Usuarios
            WHERE correoElectronico = p_correoElectronico;
WHEN 6 THEN UPDATE
                Usuarios
            SET status = 'A', numIntentos = 0
            WHERE correoElectronico = p_correoElectronico;
WHEN 7 THEN UPDATE
                Usuarios
            SET status = 'A', numIntentos = 0, contrasena = p_contrasena
            WHERE correoElectronico = p_correoElectronico;
END CASE;


END$$

DELIMITER ;