-- CREATE DATABASE hardware_store CHARACTER SET utf8 COLLATE utf8_general_ci;

USE hardware_store;

CREATE TABLE tipo_cliente (
    id_tipo_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    tipo_cliente INT NOT NULL,
    fecha_registro DATE NOT NULL,
    FOREIGN KEY (tipo_cliente) REFERENCES tipo_cliente(id_tipo_cliente)
);

CREATE TABLE producto (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre_producto VARCHAR(100) NOT NULL,
    imagen VARCHAR(1000) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL
);

CREATE TABLE cotizacion (
    id_cotizacion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    fecha_cotizacion DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    descuento_aplicado DECIMAL(10, 2) NOT NULL,
    total_con_descuento DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE detalle_Cotizacion (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_cotizacion INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_cotizacion) REFERENCES cotizacion(id_cotizacion),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
);

INSERT INTO tipo_cliente (nombre) VAlUES ("Permanente"),("Periodico"),("Casual"), ("Nuevo");