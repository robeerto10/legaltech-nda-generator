# ⚖️ LegalTech NDA Generator (Portfolio 2º DAW)

Un Micro-SaaS desarrollado con **Vanilla PHP 8, Vanilla JS y MySQL (PDO)**. Funciona como una prueba de concepto para la generación automatizada de Acuerdos de Confidencialidad (NDA).

Este proyecto evidencia la capacidad de crear arquitecturas Cliente-Servidor robustas y estructuradas, aplicando la separación lógica de responsabilidades en el frontend.

## 📁 Estructura del Proyecto

El proyecto sigue las mejores prácticas de estructuración (Separation of Concerns):
- `css/styles.css`: Capa de presentación (UI/UX).
- `js/app.js`: Capa de interacción y peticiones asíncronas HTTP.
- `index.html`: Estructura semántica.
- `procesar.php`: Capa de negocio, persistencia y generación de binarios PDF.

## 🛠️ Tecnologías Utilizadas

* **Frontend:** HTML5, CSS3 (variables, grid, flexbox, animaciones) y JavaScript Moderno (ES6+, Fetch API, Promises).
* **Backend:** PHP 8 (Orientado a objetos, uso de PDO para persistencia).
* **Base de Datos:** MySQL / MariaDB (Motor InnoDB).
* **Dependencias de terceros:** [FPDF](http://www.fpdf.org/).

## 🚀 Buenas Prácticas Aplicadas

1.  **Prevención de Inyecciones SQL:** Uso estricto de **Sentencias Preparadas con PDO**.
2.  **Prevención XSS:** Saneamiento de los datos de entrada en el servidor (`htmlspecialchars`).
3.  **Trazabilidad (Audit Trail):** ID autoincremental único en base de datos insertado en el PDF.
4.  **Optimización de Carga:** Archivos estáticos separados; carga de JS diferida con el atributo `defer`.

## ⚙️ Despliegue Local (Entorno XAMPP/MAMP)

1. Mueve esta carpeta al directorio público de tu servidor web (e.g., `htdocs` en XAMPP).
2. Abre `phpMyAdmin` y ejecuta el script proporcionado en el archivo `database.sql` para levantar la estructura de datos.
3. Accede al proyecto a través de tu navegador (e.g., `http://localhost/legaltech_portfolio`).
