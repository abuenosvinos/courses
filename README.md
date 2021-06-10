
## Preparación

Una vez hayas descargado el proyecto en tu ordenador, deberás ejecutar los siguientes comandos.

Preparación de la infraestructura.

```bash
docker-compose -f ./docker/docker-compose.yml up -d --build
```

Instalación de las dependencias de la aplicación.

```bash
docker exec -it -u $(id -u ${USER}):$(id -g ${USER}) course_php php /var/www/composer.phar install
```

Creación de la base de datos.

```bash
docker exec -it course_php php bin/console doctrine:schema:update --force
```

Creación de la base de datos de test.

```bash
docker exec -it course_php php bin/console doctrine:schema:update --force --env=test
```

## Pruebas

Para ejecutar la suite de pruebas ejecuta el siguiente comando.

```bash
docker exec -it -u $(id -u ${USER}):$(id -g ${USER}) course_php ./vendor/bin/simple-phpunit
```

## Load data

El siguiente comando es el que obtiene los cursos de la fuente original. Este comando deberá ser ejecutado diariamente para obtener las actualizaciones de información.

```
docker exec -it course_php php bin/console app:sync-source-truth
```

## Ejecución

La ejecución del docker-compose.yml ha levantado una instancia de nginx y php-fpm para poder recibir las peticiones http

En la carpeta `tests` se pueden encontrar tres formas de ejecutar el buscador:

- `curl.txt` para ejecutarlo por consola
- `http-requests` scripts de ejecución dentro de phpstorm
- `postman` para importarlo en postman

## Mejoras

- Creacíón dinámica de usuarios
- Login de usuario y obtención de token de manera dinámica
- Permitir marcar como favoritos los cursos
- Establecer diferentes precios en función de diferentes monedas
- Paginación y mejora en formato de respuesta del buscador para adaptarlo a la paginación, siguiente url, url anterior, ...
