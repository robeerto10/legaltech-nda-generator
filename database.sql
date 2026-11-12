-- Script de despliegue de Base de Datos para Proyecto LegalTech
-- Alumno 2º DAW

CREATE DATABASE IF NOT EXISTS legaltech DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE legaltech;

CREATE TABLE IF NOT EXISTS contratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    cliente VARCHAR(255) NOT NULL,
    clausulas TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
