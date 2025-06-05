# 🚀 Proyecto Laravel 12 - Biblioteca

Este es un proyecto backend desarrollado con [Laravel 12](https://laravel.com/docs/12.x), utilizando PHP 8.2.28 y Composer 2.8.8 para gestionar dependencias y desarrollo moderno en PHP.

---

## 📦 Tecnologías principales

- 🐘 **PHP** `v8.2.28`
- 🧰 **Composer** `v2.8.8`
- 🌐 **Laravel Framework** `v12.0`
- 🔐 **Laravel Sanctum** `v4.0` (Autenticación API)
- 🛠️ **PHPUnit** `v11.5.3` (Testing)

---

## 🛠️ Instalación y uso

Sigue estos pasos para ejecutar el proyecto localmente:

### 1. Clonar el repositorio

```bash
git clone https://github.com/Joel-391/Biblioteca-laravel.git
```

### 2. Acceder a la carpeta del proyecto
```bash
cd Biblioteca-laravel
```

### 3. Instalar dependencias
```bash
composer install
```

### 4. Configurar la base de datos .env
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=Biblioteca
DB_USERNAME=
DB_PASSWORD=
```

### 5. Ejecutar migraciones
```bash
php artisan migrate:fresh --seed
```

### 6. Iniciar el servidor
```bash
php artisan serve
```
