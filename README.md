
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

Para verificar la cálidad del código

```bash
docker exec -it -u $(id -u ${USER}):$(id -g ${USER}) course_php ./vendor/bin/phpcs --standard=PSR12 src tests --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1
```

## Usuarios

Dentro de la carpeta `tests/userTest` se pueden encontrar tres formas de ejecutar el buscador: 

- `curl.txt` para ejecutarlo por consola
- `http-requests` scripts de ejecución dentro de phpstorm
- `postman` para importarlo en postman

Para crear los usuarios de prueba que contienen estas urls hay que ejecutar los siguientes comandos:

```bash
docker exec -it course_php php bin/console app:new-user abuenosvinos
docker exec -it course_php php bin/console app:new-user manolo
```

Se puede crear cualquier usuario que se considere.

Para obtener su clave de acceso hay que lanzar el comando:

```bash
docker exec -it course_php php bin/console app:get-token-user abuenosvinos
```

Dicho token deberá ser utilizado como valor de la cabecera `X-AUTH-TOKEN`

## Load data

El siguiente comando es el que obtiene los cursos de la fuente original. Este comando deberá ser ejecutado diariamente para obtener las actualizaciones de información.

```bash
docker exec -it course_php php bin/console app:sync-source-truth
```

## Ejecución

La ejecución del docker-compose.yml ha levantado una instancia de nginx y php-fpm para poder recibir las peticiones http, por lo que ya se pueden ejecutar las pruebas indicadas en el apartado Usuarios o crear nuevos usuarios y realizar diferentes peticiones http.

## Finalización

Una vez finalizadas las pruebas deberás ejecutar el siguiente comando.

```bash
docker-compose -f ./docker/docker-compose.yml down
```

## Mejoras

- Permitir marcar como favoritos los cursos
- Establecer diferentes precios en función de diferentes monedas
