---
tags:
  - DataBases
  - Eloquent
  - Laravel
---

# Contenido


# ¿Qué es Casting en Laravel?

Es una forma más genérica de modificar al como se va amostrar al usuario lo capturado desde la tabla de un base de datos(método parecido a los [[🐘Mutadores y Accesores|mutadores y accesores]]).

# Uso

Por ejemplo, usando `Models/Artist.php` en el archivo `web.php` al capturar la fecha como atributo (esto se puede hacer gracias a una librería de Laravel ([Carbón](https://carbon.nesbot.com/docs)) que solo funciona con id's y fechas de creación y actualización) podemos cambiar el formato de esta fecha.

En este caso se cambia el formato original que esta en la base de datos a un formato *day/month/year*:

```php
$artist = new Artist;
$artist = Artist::find(5);
return $artist->created_at->format('d/m/y');
```

# Casts.

La función `casts()` lo que hace es transformar los strings de la tabla (campos) en un tipo de dato manipulable por [Carbon](https://carbon.nesbot.com/docs), en este caso **Carbon** lo que permitirá es darle formato de fecha a algún otro campo además de ``created_at`` y ``updated_at``. Por ejemplo, que se haya creado un campo llamado `registered_at`, en un inicio este campo será tratado como ``string``, inclusive si en la base de datos se le dio formato de fecha.

Para ello, en el archivo (de ejemplo) `Models/Artist.php` cambiaremos el formato del campo `registered_at` de `string` a `datetime`:

```php
protected function casts(): Array
{
	return [
		'registered_at' => 'datetime'
	];
}
```

Para ver mas propiedades de `custom casting` visitar [Laravel Docs](https://laravel.com/docs/12.x).

==Las propiedades cambiadas por **Carbon** no solo aplican para lectura, sino que también para escritura en la base de datos.==