-- Base de datos de ARDUNOVA
CREATE DATABASE IF NOT EXISTS ardunova CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ardunova;

-- Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuarios INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tutoriales (para poder referenciarlos desde la tabla de progreso)
CREATE TABLE IF NOT EXISTS tutoriales (
    id_tutorial INT AUTO_INCREMENT PRIMARY KEY,
    categoria_t VARCHAR(20) NOT NULL
);

-- Tabla intermedia: tutorial completado por cada usuario
-- completado: 1 = completado, 0 = no completado
CREATE TABLE IF NOT EXISTS progreso (
    id_progreso INT AUTO_INCREMENT PRIMARY KEY,
    id_usuarios INT NOT NULL,
    id_tutorial INT NOT NULL,
    completado BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_usuarios) REFERENCES usuarios(id_usuarios)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_tutorial) REFERENCES tutoriales(id_tutorial)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE (id_usuarios, id_tutorial),
    CHECK (completado IN (0, 1))
);

-- Categorías de los tutoriales
INSERT INTO tutoriales (id_tutorial, categoria_t) VALUES
    (1, 'Principiante'), (2, 'Principiante'), (3, 'Principiante'), (4, 'Principiante'),
    (5, 'Principiante'), (6, 'Principiante'), (7, 'Principiante'), (8, 'Principiante'),
    (9, 'Intermedio'), (10, 'Intermedio'), (11, 'Intermedio'), (12, 'Intermedio'),
    (13, 'Intermedio'), (14, 'Intermedio'), (15, 'Intermedio'), (16, 'Intermedio'),
    (17, 'Avanzado'), (18, 'Avanzado'), (19, 'Avanzado'), (20, 'Avanzado'),
    (21, 'Avanzado'), (22, 'Avanzado'), (23, 'Avanzado'), (24, 'Avanzado');

-- PROYECTOS 
-- Proyectos (para poder referenciarlos desde la tabla de progreso)
CREATE TABLE IF NOT EXISTS proyectos (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    categoria_p VARCHAR(20) NOT NULL
);
-- Categorías de los proyecto
INSERT INTO proyectos (id_proyecto, categoria_p) VALUES
    (1, 'Principiante'),(2, 'Intermedio'),(3, 'Principiante'),(4, 'Intermedio'),
    (5, 'Intermedio'),(6, 'Principiante'),(7, 'Principiante'),(8, 'Intermedio'),
    (9, 'Avanazado'),(10, 'Avanzado'),(11, 'Avanzado'),(12, 'Intermedio');

--Agregamos las columnas correspondientes a la tabla progreso.
 ALTER TABLE progreso
     MODIFY COLUMN id_tutorial INT NULL;

 ALTER TABLE progreso
    -MODIFY COLUMN id_tutorial INT NULL;

ALTER TABLE progreso
     ADD CONSTRAINT unique_usuario_proyecto UNIQUE (id_usuarios, id_proyecto);
