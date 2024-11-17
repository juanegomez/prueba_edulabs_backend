# Edulabs Backend

Este proyecto es una aplicación backend desarrollada en Laravel. A continuación, se describen las instrucciones para configurar y ejecutar el entorno de desarrollo.

## Requisitos del Sistema

-   **Sistema Operativo:** Ubuntu (recomendado)
-   **Docker:** Versión `27.3.1` (recomendada)
-   **Docker Compose:** Versión `v2.28.1` (recomendada)

## Configuración del Proyecto

1.  **Clonar el proyecto:**
    Asegúrate de haber clonado este repositorio en tu máquina local.

2.  **Crear el archivo de configuración:**
    Clona el archivo `.env.example` en un nuevo archivo `.env` y configura las credenciales de la base de datos como se indica a continuación:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=edulabs_db
    DB_USERNAME=root
    DB_PASSWORD=adm1n123!

    ```

3.  **Construir los contenedores:** Ejecuta el siguiente comando para construir los contenedores Docker:

    ```
    docker compose build

    ```

4.  **Iniciar los contenedores:** Inicia los contenedores en modo "detached" (en segundo plano):

    ```
    docker compose up -d

    ```

5.  **Acceder al contenedor de Laravel:** Para interactuar con el contenedor de Laravel, ejecuta:

    ```
    docker exec -it laravel-app /bin/bash

    ```

## Instalación y Configuración del Proyecto Laravel

Dentro del contenedor de Laravel, sigue estos pasos:

1. **Instalar las dependencias de Composer:**

    ```
    composer install

    ```

2. **Ejecutar las migraciones de la base de datos:**

    ```
    php artisan migrate

    ```

3. **Ejecutar los seeders (datos de prueba):**

    ```
    php artisan db:seed
    ```

## Notas Adicionales

-   Asegúrate de que Docker y Docker Compose estén correctamente instalados antes de comenzar.

-   Si encuentras problemas con las migraciones o seeds, verifica que las credenciales de la base de datos sean correctas y que el servicio MySQL esté en ejecución dentro del contenedor laravel-mysql.

**¡El proyecto ahora debería estar funcionando correctamente!**
