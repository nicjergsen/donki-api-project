# Proyecto API DONKI Instrument Usage

Este proyecto es una API Rest construida con Laravel, diseñada para consumir las APIs de DONKI (NASA) y procesar datos sobre instrumentos y actividades. Implementa Clean Architecture y principios SOLID para asegurar modularidad y escalabilidad.

---

## Tabla de Contenidos

1. [Requisitos](#requisitos)
2. [Instalación](#instalación)
3. [Ejecución](#ejecución)
4. [Estructura del Proyecto](#estructura-del-proyecto)
5. [Endpoints](#endpoints)


---

## Requisitos

Antes de empezar, asegúrate de cumplir con los siguientes requisitos:

- **PHP:** >= 8.1
- **Composer:** >= 2.0
- **Laravel:** 10.x
- **Servidor HTTP:** Apache o Nginx
- **Guzzle HTTP Client:** ^7.0
- **API Key NASA:** Generar una API key en [NASA API Portal](https://api.nasa.gov/).

---

## Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/nicjergsen/donki-api-project.git
   cd donki-api-project

2. Instalar las dependencias:
   ```bash
   composer install

3. Crear el archivo .env:
   ```bash
   cp .env.example .env

4. Generar la clave de la aplicación:
   ```bash
   php artisan key:generate

5. Configurar las variables de entorno en .env:
   ```bash
    NASA_API_BASE_URL=https://api.nasa.gov/
    NASA_API_KEY=TU_API_KEY_AQUI

## Ejecución

Para ejecutar el proyecto localmente:

1. Iniciar el servidor de local de Laravel:
    ```bash
    php artisan serve

2. Acceder a la aplicación: Visita http://localhost:8000

## Estructura del Proyecto

    app/
    ├── Application/
    │   ├──  UseCases               # Casos de Uso
    │   ├──  Services               #Servicios
    ├── Domain/
    │   ├── Entities                # Entidades del Dominio
    │   ├── Repositories            # Interfaces de Repositorios
    ├── Infrastructure/
    │   ├── Repositories            # Implementación de Repositorios
    ├── Http/
    │   ├── Controllers             # Implementación de Repositorios
    ├── Providers                   # Proveedores de Servicios
    config/
    routes/
    └── api.php                     # Definición de Rutas API

## Endpoints

1. Obtener Instrumentos:

    Ruta: /api/instruments

    Método: GET

2. Porcentaje de Uso de Actividades por Instrumento:

    Ruta: /api/instrument-activity
    
    Método: GET
    
    Parámetro de Consulta: instrument

3. Porcentaje Global de Uso de Instrumentos:

    Ruta: /api/instrument-usage
    
    Método: GET

4. Obtener Actividades

    Ruta: /api/activities

    Método: GET