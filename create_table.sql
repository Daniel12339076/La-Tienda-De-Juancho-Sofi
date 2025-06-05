CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    descripcion VARCHAR(100),
    imagen VARCHAR(50)
);

CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50),
    precio_unitario VARCHAR(150),
    cantidad INT,
    descuento INT,
    imagen VARCHAR(50),
    id_categoria INT,
    tallas VARCHAR(200),
    colores VARCHAR(100),
    descripcion TEXT,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255),
    correo VARCHAR(150),
    celular INT,
    clave VARCHAR(100),
    rol VARCHAR(50)
);

CREATE TABLE ordenes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATE,
    total INT,
    codigo VARCHAR(9),
    tipo_venta ENUM('online', 'local'),
    estado ENUM('Solicitado', 'Atendido', 'Entregado', 'Rechazado'),
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE ventas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT,
    cantidad INT,
    valor_total INT,
    id_orden INT,
    FOREIGN KEY (id_producto) REFERENCES productos(id),
    FOREIGN KEY (id_orden) REFERENCES ordenes(id)
);

CREATE TABLE contactar (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(60),
    celular BIGINT
);

-- Insertar un usuario administrador por defecto
-- La contraseña es 'admin123' (encriptada con password_hash)
INSERT INTO usuarios (nombre, correo, celular, clave, rol) 
VALUES ('admin', 'admin@tiendajuancho.com', '+573001234567', '$2y$10$qJQRXQGrYzYQ5Hl.Yc7X2.Q0yw0TJ9XO3y3X5V9YG9Y9Y9Y9Y9Y9Y', 'administrador')
ON DUPLICATE KEY UPDATE nombre = nombre;