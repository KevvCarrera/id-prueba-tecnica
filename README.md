# Prueba Técnica ID

Este proyecto es una aplicación desarrollada con **Laravel 12** que gestiona productos y ventas, implementando:

- **Autenticación con tokens** mediante Laravel Sanctum.
- **Control de roles y permisos** con Spatie Laravel-Permission.
- **Exportación de datos** a **Excel y JSON**.
- **Validaciones** a través de **Form Requests**.
- **Patrón de diseño Repository** con servicios.
- **Documentación de la API** utilizando Swagger.

---
## 📑 Tabla de Contenidos
- [Características Principales](#caracteristicas-principales)
- [Tecnologías Utilizadas](#tecnologias-utilizadas)
- [Requisitos Previos](#requisitos-previos)
- [Instalación](#instalacion)
- [Configuración](#configuracion)
- [Migraciones y Seeders](#migraciones-y-seeders)
- [Rutas de la API](#rutas-de-la-api)
- [Autenticación y Autorización](#autenticacion-y-autorizacion)
- [Exportación de Datos](#exportacion-de-datos)
- [Validaciones](#validaciones)
- [Patrón Repository y Servicios](#patron-repository-y-servicios)
- [Documentación con Swagger](#documentacion-con-swagger)
- [Pruebas](#pruebas)
- [Despliegue](#despliegue)
- [Contribuciones](#contribuciones)
- [Contacto](#contacto)

---
## 🚀 Características Principales
- **Gestión de Productos y Ventas**: Creación, actualización, visualización y eliminación de productos y ventas.
- **Autenticación con Laravel Sanctum**: Basada en tokens para proteger las rutas de la API.
- **Roles y Permisos con Spatie**: Control de acceso mediante roles y permisos.
- **Exportación de Datos**: Exportación de datos en **Excel y JSON**.
- **Validaciones con Form Requests**: Garantiza la integridad de los datos.
- **Patrón Repository y Servicios**: Separación de lógica de acceso a datos y negocio.
- **Documentación con Swagger**: API documentada para facilitar su uso.

---
## 🛠 Tecnologías Utilizadas
- **Lenguaje**: PHP 8.3
- **Framework**: Laravel 12
- **Base de Datos**: MySQL
- **Autenticación**: Laravel Sanctum
- **Control de Roles y Permisos**: Spatie Laravel-Permission
- **Exportación de Datos**: Laravel Excel
- **Documentación de la API**: Swagger con DarkaOnLine/L5-Swagger

---
## 📋 Requisitos Previos
Antes de comenzar, asegúrate de tener instalados:

- PHP **8.3** o superior
- **Composer**
- **MySQL**
- **Servidor web** (Apache, Nginx, etc.)

---
## 🔧 Instalación
### 1️⃣ Clonar el repositorio:
```bash
git clone https://github.com/tu-usuario/prueba-tecnica-id.git
cd prueba-tecnica-id
```
### 2️⃣ Instalar las dependencias:
```bash
composer install
```
---
## ⚙️ Configuración
### 1️⃣ Copiar el archivo de configuración de ejemplo:
```bash
cp .env.example .env
```
### 2️⃣ Configurar variables en **.env**:
```ini
APP_NAME=PruebaTecnicaID
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_bd
DB_USERNAME=root
DB_PASSWORD=
```
### 3️⃣ Generar la clave de la aplicación:
```bash
php artisan key:generate
```
---
## 🏗️ Migraciones y Seeders
### 1️⃣ Ejecutar las migraciones:
```bash
php artisan migrate
```
### 2️⃣ Ejecutar los seeders para roles y permisos:
```bash
php artisan db:seed
```
---
## 🔀 Rutas de la API

### **Autenticación**:
```http
POST /register   → Registro de usuarios
POST /login      → Inicio de sesión y obtención de token
```
### **Productos (Autenticación + Permisos)**:
```http
GET /products                  → Lista todos los productos (list-product)
POST /products                 → Crea un producto (create-product)
PUT /products/{product}        → Actualiza un producto (update-product)
DELETE /products/{product}     → Elimina un producto (delete-product)
```
### **Ventas (Autenticación + Permisos)**:
```http
GET /sales                   → Lista todas las ventas (list-sales)
POST /sales                  → Crea una nueva venta (create-sales)
PUT /sales/{sale}            → Actualiza una venta (update-sales)
DELETE /sales/{sale}         → Elimina una venta (delete-sales)
```
### **Reportes de Ventas (Solo Admin)**:
```http
GET /sales/report  → Genera un reporte de ventas
```
---
## 🔑 Autenticación y Autorización
- **Laravel Sanctum** maneja la autenticación basada en tokens.
- **Spatie Laravel-Permission** administra los roles y permisos.

---
## 📤 Exportación de Datos
Permite exportar productos y ventas en **Excel y JSON** con Laravel Excel.

---
## ✅ Validaciones
- Se realizan mediante **Form Requests** para garantizar la integridad de los datos.

---
## 🏗️ Patrón Repository y Servicios
- **Repository Pattern** para desacoplar la lógica de negocio y acceso a datos.
- **Servicios** que encapsulan la lógica de negocio.

---
## 📄 Documentación con Swagger
Swagger proporciona una documentación interactiva para probar la API.
Para generar la documentación:
```bash
php artisan l5-swagger:generate
```
Acceder desde:
```
http://localhost/api/documentation
```
---
## 🧪 Pruebas
Ejecutar pruebas unitarias con:
```bash
php artisan test
```

---
## 🚀 Despliegue
Para subir la aplicación a producción:
```bash
php artisan config:cache
php artisan route:cache
php artisan migrate --force
```
---
## 🤝 Contribuciones
Si deseas contribuir, por favor abre un **issue** o envía un **pull request** en GitHub.

---
## 📞 Contacto
📧 **Correo**: k.carrera.1512@gmail.com  
📱 **Teléfono**: +51 921642399

