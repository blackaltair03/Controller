# Documentación de Pruebas y Réplica

Este proyecto utiliza PHPUnit para las pruebas automatizadas.

## Ejecución de Pruebas

1. **Instalar dependencias:**
   
   Ejecuta en la raíz del proyecto:
   
   ```bash
   composer install
   ```

2. **Configurar el entorno de pruebas:**
   
   - Copia el archivo `.env.example` a `.env` si existe.
   - Configura la base de datos de pruebas en `.env` (por ejemplo, usando SQLite o la base de datos que prefieras).
   - Ejecuta las migraciones:
     
   ```bash
   php artisan migrate --env=testing
   ```

3. **Ejecutar las pruebas:**
   
   ```bash
   ./vendor/bin/phpunit
   ```
   o
   ```bash
   php artisan test
   ```

## Réplica del Entorno de Pruebas

Para replicar el entorno de pruebas en otra máquina:

1. Clona el repositorio:
   ```bash
   git clone <url-del-repositorio>
   ```
2. Sigue los pasos de instalación y configuración anteriores.
3. Asegúrate de tener PHP, Composer y las extensiones necesarias instaladas.

## Estructura de Pruebas

- Las pruebas se encuentran en el directorio `tests/`.
- Se dividen en:
  - `Feature/`: Pruebas de características completas.
  - `Unit/`: Pruebas unitarias de clases y métodos.

## Notas
- Puedes personalizar la configuración de PHPUnit en `phpunit.xml`.
- Si usas una base de datos diferente, actualiza la configuración en `.env` y en `phpunit.xml` si es necesario.

---

Para cualquier duda, consulta la documentación oficial de Laravel y PHPUnit.
