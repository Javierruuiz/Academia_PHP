-- MI BASE DE DATOS -- USUARIO adminNuevo CONTRASEÑA nuevaContraseña123
DROP DATABASE IF EXISTS academia;
CREATE DATABASE academia;
USE academia;

DROP TABLE IF EXISTS alumnos;
CREATE TABLE alumnos (
                         id INT(11) NOT NULL AUTO_INCREMENT,
                         nombre VARCHAR(50) NOT NULL,
                         apellidos VARCHAR(50) NOT NULL,
                         id_padre INT(11) NOT NULL,
                         PRIMARY KEY (id),
                         KEY id_padre (id_padre)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS materias;
CREATE TABLE materias (
                          id INT(11) NOT NULL AUTO_INCREMENT,
                          nombre_materia VARCHAR(100) NOT NULL,
                          id_profesor INT(11) NOT NULL,
                          PRIMARY KEY (id),
                          KEY id_profesor (id_profesor)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS pruebas;
CREATE TABLE pruebas (
                         id INT(11) NOT NULL AUTO_INCREMENT,
                         id_materia INT(11) NOT NULL,
                         trimestre ENUM('primero', 'segundo', 'tercero') NOT NULL,
                         id_alumno INT(11) NOT NULL,
                         nota DECIMAL(4,2) NOT NULL,
                         horario VARCHAR(30) NOT NULL,
                         PRIMARY KEY (id),
                         KEY id_materia (id_materia),
                         KEY FK_pruebas_alumnos (id_alumno)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
                          id INT(11) NOT NULL AUTO_INCREMENT,
                          nombre VARCHAR(50) NOT NULL,
                          apellidos VARCHAR(50) NOT NULL,
                          nombre_usuario VARCHAR(30) NOT NULL,
                          rol VARCHAR(20) NOT NULL,
                          pass VARCHAR(255) NOT NULL,
                          PRIMARY KEY (id),
                          UNIQUE KEY nombre_usuario (nombre_usuario)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE alumnos ADD CONSTRAINT FK_alumnos_usuarios FOREIGN KEY (id_padre) REFERENCES usuarios (id);
ALTER TABLE materias ADD CONSTRAINT FK_materias_usuarios FOREIGN KEY (id_profesor) REFERENCES usuarios (id);
ALTER TABLE pruebas ADD CONSTRAINT FK_pruebas_alumnos FOREIGN KEY (id_alumno) REFERENCES alumnos (id),
                    ADD CONSTRAINT FK_pruebas_materias FOREIGN KEY (id_materia) REFERENCES materias (id);

-- Insertamos datos en la tabla 'usuarios'
INSERT INTO usuarios (nombre, apellidos, nombre_usuario, rol, pass)
VALUES
    ('Pedro', 'Sánchez', 'adminNuevo', 'admin', '$2y$10$Ks0ZJA0J6jrdV2CNR0.t5ux5vvnE2S68YIqeXMrEG5vgCmcxmbJy.'), -- la contraseña es admin
    ('Laura', 'Martínez', 'lauraM', 'padre', '$2y$10$Ks0ZJA0J6jrdV2CNR0.t5ux5vvnE2S68YIqeXMrEG5vgCmcxmbJy.'),
    ('Carlos', 'Gómez', 'carlosG', 'profesor', '$2y$10$Ks0ZJA0J6jrdV2CNR0.t5ux5vvnE2S68YIqeXMrEG5vgCmcxmbJy.');

-- Insertamos datos en la tabla 'alumnos'
INSERT INTO alumnos (nombre, apellidos, id_padre)
VALUES
    ('Alejandro', 'Serrano', 22),   -- id_padre 2 (Laura Martínez)
    ('Lucía', 'Fernández', 22),     -- id_padre 2 (Laura Martínez)
    ('Sofía', 'Hernández', 23);     -- id_padre 3 (Carlos Gómez)

-- Insertamos datos en la tabla 'materias'
INSERT INTO materias (nombre_materia, id_profesor)
VALUES
    ('Matemáticas', 23),            -- id_profesor 3 (Carlos Gómez)
    ('Historia', 23),               -- id_profesor 3 (Carlos Gómez)
    ('Ciencias Naturales', 23);     -- id_profesor 3 (Carlos Gómez)

-- Insertamos datos en la tabla 'pruebas'
INSERT INTO pruebas (id_materia, trimestre, id_alumno, nota, horario)
VALUES
    (32, 'primero', 8, 8.75, '10:00 AM - 12:00 PM'),
    (33, 'segundo', 9, 9.25, '1:00 PM - 3:00 PM'),
    (34, 'tercero', 10, 7.50, '4:00 PM - 6:00 PM');
