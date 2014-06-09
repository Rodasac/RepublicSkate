RepublicSkate
=============

Página web para Republic Skate S.R.L.

Para comenzar debes descargar composer:

```
curl -sS https://getcomposer.org/installer | php
```

 y desde la consola ejecutar: 

```
php composer.phar update
php composer.phar install
```

Si no tienes instalado la extension FPDF en PHP descárgala en la página oficial
y copía la el contenido en el directorio vendor generado en el paso anterior;
si en cambio si tienes FPDF instalado borra la importación en el archivo "bootstrap.php".

Happy coding!