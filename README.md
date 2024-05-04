# Proyecto Laravel CRUD API

Este es un proyecto de API CRUD (Crear, Leer, Actualizar, Eliminar) implementado con Laravel.

## Instalación

1. Clona este repositorio en tu máquina local usando `https://github.com/santiagocode/laravel-crud-api.git`
2. Navega a la carpeta del proyecto `cd laravel-crud-api`
3. Instala las dependencias con Composer `composer install`
4. Copia el archivo `.env.example` a `.env` y configura tus variables de entorno
5. Genera una clave de aplicación con `php artisan key:generate`
6. Ejecuta las migraciones con `php artisan migrate`
7. Inicia el servidor de desarrollo local con `php artisan serve`

## Uso

La API tiene los siguientes endpoints:

-   `GET /api/students`: Obtiene una lista de todos los estudiantes
-   `GET /api/students/{id}`: Obtiene los detalles de un estudiante específico
-   `POST /api/students`: Crea un nuevo estudiante
-   `PUT /api/students/{id}`: Actualiza un estudiante existente
-   `DELETE /api/students/{id}`: Elimina un estudiante

## Contribuir

Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request para cualquier contribución.

## Licencia

Este proyecto está licenciado bajo la licencia MIT.
