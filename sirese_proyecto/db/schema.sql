CREATE DATABASE IF NOT EXISTS sirese CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sirese;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO roles (nombre) VALUES ('ADMIN'), ('RECEPCIONISTA'), ('CLIENTE');

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(30),
    password_hash VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

CREATE TABLE tipos_evento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

INSERT INTO tipos_evento (nombre) VALUES
('15 años'),
('Matrimonio'),
('Grado'),
('Reunión de empresarias'),
('Reunión corporativa'),
('Otro');

CREATE TABLE platos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(255),
    tipo VARCHAR(20) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

INSERT INTO platos (nombre, descripcion, tipo, precio) VALUES
('Bandeja montañera', NULL, 'RESTAURANTE', 0),
('Sancocho de gallina (pernil)', NULL, 'RESTAURANTE', 0),
('Sancocho de gallina (pechuga)', NULL, 'RESTAURANTE', 0),
('Lomo de res', NULL, 'RESTAURANTE', 0),
('Lomo de cerdo', NULL, 'RESTAURANTE', 0),
('Churrasco', 'Elegir término: 3/4, medio, bien asado, azul', 'RESTAURANTE', 0),
('Costilla ahumada', NULL, 'RESTAURANTE', 0),
('Costilla BBQ', NULL, 'RESTAURANTE', 0),
('Filete de pechuga', NULL, 'RESTAURANTE', 0),
('Tilapia', NULL, 'RESTAURANTE', 0);

CREATE TABLE dias_festivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL UNIQUE,
    descripcion VARCHAR(150)
);

CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_reserva ENUM('EVENTO','RESTAURANTE') NOT NULL,
    cliente_id INT NOT NULL,
    creado_por_id INT NOT NULL,
    tipo_evento_id INT NULL,
    plato_id INT NULL,
    termino_churrasco ENUM('3/4','MEDIO','BIEN ASADO','AZUL') NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    numero_personas INT NOT NULL,
    especificaciones_cliente TEXT,
    estado ENUM('PENDIENTE','CONFIRMADA','CANCELADA') DEFAULT 'PENDIENTE',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES usuarios(id),
    FOREIGN KEY (creado_por_id) REFERENCES usuarios(id),
    FOREIGN KEY (tipo_evento_id) REFERENCES tipos_evento(id),
    FOREIGN KEY (plato_id) REFERENCES platos(id)
);
