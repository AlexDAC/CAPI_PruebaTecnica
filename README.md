# CAPI_PruebaTecnica
Prueba Técnica Desarrollada en Laravel y Angular 

## Stack
Proyecto desarrollado en laravel 11 y Angular 17

El versionamiento de php es 8.2.24
mientras que el versionamiento de node es 20.17.0

## Septup
El manejador de paquetes a utilizar en backend es **Composer**
Mientras que en el frontend es **npm**

## Instalación Backend
ingresar a la carpeta del backend desde la terminal
ejecutando el siguiente comando
**cd address_book_app_backend**

ejecutaremos el comando **composer install**

una vez dentro generaremos el .env exactamente de la forma del .env.example
ejecutaremos en la terminal el siguiente comando
**cp .env.example .env**

y a su vez le generaremos una key desde la terminal con el comando
**php artisan key:generate**

estos pasos en el archivo .env modificaremos la variable **APP_TIMEZONE**
colocando **America/Mexico_City**

en este mismo archivo (.env) descomentaremos las variables 
**DB_CONNECTION**
**DB_HOST**
**DB_PORT**
**DB_DATABASE**
**DB_USERNAME**
**DB_PASSWORD**
y les asignaremos los valores correspondientes los cuales depende de tu configuración y parámetros

solamente las variables **DB_CONNECTION**, 
la cual le asignaremos el valor **mysql** quedando **DB_CONNECTION=mysql**,
y a la variable **DB_DATABASE** la dejaremos vacia, quendando **DB_DATABASE=**

En la terminal ejecutaremos el comando 
**php artisan make:database** más espacio, más el nombre de la base de datos que queremos asignarle, la cual no debemos de tener en existencia, quendando por ejemplo
**php artisan make:database pt_capi**

despues ejecutaremos en la terminal los comandos
**php artisan migrate** y **php artisan db:seed**

finalmente ejecutaremos en la terminal el servicio con el comando
**php artisan serve**