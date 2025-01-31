# Prueba Técnica PHP - Marco Cisterna

## Descripción
Este proyecto implementa un sistema de gestión de usuarios siguiendo los principios de Arquitectura Limpia (Clean Architecture) y Domain-Driven Design (DDD).

## Requisitos Previos
- PHP 8.1
- Composer
- PHPUnit


## Instalación

1. Clonar el repositorio:

2. Instalar dependencias:
```bash
composer install
```

## Ejecutar Tests

### Ejecutar todos los tests
```bash
./vendor/bin/phpunit
```

### Ejecutar tests específicos
```bash

./vendor/bin/phpunit tests/Infrastructure/Repository


./vendor/bin/phpunit tests/Infrastructure/Repository/InMemoryUserRepositoryTest.php


./vendor/bin/phpunit --filter testSaveAndRetrieveUser tests/Infrastructure/Repository/InMemoryUserRepositoryTest.php
```
