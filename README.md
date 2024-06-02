Para el correcto funcionamiento del programa se necesitara descargar el programa XAMPP, 
cuando se instala el programa tenemos que irnos a la carpeta "XAMPP" donde se instalo
(usualmente es en el disco local C) y dentro de la carpeta llamada "HTDOCS" es donde tenemos
que descargar todos los archivos del repositorio.
----------------------------------------------------------------------------------------------------------------------
Para contar con la base de datos necesitaremos ingresar al phpmyadmin dandole click al boton "admin" al lado de Mysql 
que los podemos ver una vez hayamos ejecutado el XAMPP en nuestras PCs. Lo unico que debemos 
hacer en este punto es crear una base de datos llamada "carrito" en el phpmyadmin y exportar el archivo .sql
del repositorio (que se supone que estara instalada en la carpeta htdocs).
----------------------------------------------------------------------------------------------------------------------
El codigo se ejecuta en el programa Visual Studio Code, tienen que abrir la carpeta desde el mismo programa.
Para que pueda funcionar el coodigo PHP necesitaremos instalar las siguientes extensiones:
- PHP Debug
- PHP Extension Pack
- PHP Intelephense
- PHP IntelliSense
- PHP Server (para ejecutar el programa necesitaremos esta extension, simplemente damos click derecho a cualquier parte
  del codigo y gracias a esta extesion habra una opcion llamada "PHP Server: Serve Project")
----------------------------------------------------------------------------------------------------------------------
El ultimo paso a tener en cuenta es editar las variables de entorno del sistema, es un proceso sencillo 
donde dentro de la carpeta xampp debemos buscar la carpeta php, al entrar a esta debemos copiar la ruta 
de ese archivo, esta ruta debe ser agregada al PATH dandole click a editar en las variables de entorno del sistema.

Al ser un proceso que requiere de varios pasos, dejare un link a un video de Youtube que lo explica muy bien:
https://www.youtube.com/watch?v=eEEp_BSToQ4

----------------------------------------------------------------------------------------------------------------------
