#models #controllers #laravel-blade #Laravel 

# ¿Qué es?

Consiste en establecer una localización geográfica para el proyecto en cuestión. Esto puede servir tanto para cuestión de registros de campos que requieran de una fecha y/u hora y para ello tenga que ser en la zona horaria, o para la traducción de textos predefinidos como los de las validaciones.

# Programación.

Para ver más acerca de la localización ver la [Documentación de Laravel](https://laravel.com/docs/12.x/localization#main-content).

Primeramente se debe ir a la terminal y escribir el siguiente comando:

```shell
php artisan lang:publish
```

Lo que hará será crear en una carpeta llamada ``lang/en`` todos los mensajes en el idioma Inglés. Para agregar más idiomas, además del propio inglés, se usará un paquete. Este paquete se llama [Laravel lang](https://laravel-lang.com/basic-usage.html#installation).

```powershell
composer require laravel-lang/common
```

Una vez instalado, este paquete nos permitirá traducir todo tipo de textos a otros idiomas (para ver que textos pueden ser traducidos, se puede ver la propia carpeta de ``lang/en``).

Para agregar un nuevo idioma se usa el comando:

```
php artisan lang:add <locale>
```

La propiedad ``locale`` hacer referencia a las iniciales del idioma. Por ejemplo, si se pone ``es`` hará un archivo en español, si se pone ``fr`` hará un archivo en francés.

Una vez ejecutado, generará las carpetas de los idiomas agregados. En añadidura, el paquete ya viene preparado para la traducción de otros paquetes con textos predeterminados.

# Configuración.

Por defecto, las validaciones seguirán tomando el idioma inglés, para cambiar ello, se debe ir al archivo ``config/app.php`` y buscar la sección de ``locale``.

En dicho archivo se encontrará esta configuración (en dicha sección de locale).

```php
'locale' => env('APP_LOCALE', 'en'),

'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),
```

Esto quiere decir, que para cambiar el idioma debemos ir al archivo de entorno, o sea ``.env`` y buscar ``APP_LOCALE`` y cambiar su valor a ``es``. Listo, los textos por predeterminado estarán traducidos.

# Agregar palabras no traducidas al array de Validaciones.

En realidad, lo de agregar palabras se puede hacer en muchos servicios, no solo en validaciones, también puede ser en auth, pagination, etc.

Para ello vamos al archivo en cuestión (este caso, ``lang/es/validation.php``) y se agrega en el arreglo llamado ``attributes``. Dentro de este se pueden hallar todos los atributos que se han traducido.

# Inglés como idioma predilecto.

Si en algún momento las traducciones del paquete Laravel lang fallan, Laravel tomará como respaldo al idioma inglés.

# Traducir (casi) cualquier frase.

Ademas de la generación de una carpeta ``es``, Laravel Lang proporciona un archivo ``.json`` llamado ``es.json`` o según el idioma, por ejemplo, en francés sería ``fr.json``.

Este archivo contiene dentro de sí múltiples frases que pueden ser traducidas. Para aplicar esta configuración, se puede ir a cualquier vista y probar poniendo la frase entre la siguiente sintaxis:

```html
<h1> {{ __("here is your frase") }} </h1>
```

El mensaje, según la configuración ``APP_LOCALE``, cambiará la frase al idioma seleccionado. Eso quiere decir, que si el idioma seteado en ``APP_LOCALE`` es español, el mensaje se traducirá para el cliente y se verá: ``aquí esta tu frase``.