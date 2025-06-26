---
tags:
  - DataBases
  - models
  - Eloquent
  - Laravel
---

# Contenido

1. [[#¿Qué es Eloquent ORM?]]
	1. [[#Eloquent]]
	2. [[#ORM]]
2. [[#Modelos]]
	1. [[#Creación de registros]]
	2. [[#Actualización de registros.]]
	3. [[#Lectura de registros.]]
	4. [[#Eliminación de registros.]]
3. [[#Convenciones.]]

``Eloquent ORM``, es una herramienta que nos va ayudar a simplificar la forma en la que trabajamos dentro de una base de datos. Mientras que en PHP puro necesitaremos que mover todo el código fuente, Laravel nos brinda muchas ayudas inclusive en la inserción, actualización y eliminación de registros dentro de una base de datos.

``Eloquent`` trabaja con ORM

# ¿Qué es Eloquent ORM?

## Eloquent

Es la herramienta que nos ayuda a interactuar con una base de datos, sus tablas y campos de la misma.

## ORM

Un ORM, o Mapeo de Objetos Relacionales (Object-Relational Mapping), es un modelo de programación que permite mapear las estructuras de una base de datos relacional a entidades lógicas. Esto quiere decir que trata las bases de datos como entidades, y a sus campos como propiedades de estas entidades, tal cual un objeto de programación orientada a objetos (POO).

# Modelos

Los modelos son los archivos en Laravel que nos permitirán interactuar con las bases de datos e implementar los registros en sus respectivos campos. Para crear un modelo usaremos:

```shell
php artisan make:model <nombre_del_modelo>
```

Creado el modelo, se debe especificar que tabla se quiere administrar, al crear un modelo, se creara en la ruta `models/` el siguiente archivo:

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    // Aqui crearemos nuestras instancias
}
```

Para este ejemplo usaremos un modelo llamado `Artist` que manipulará una tabla llamada `artist`. Este archivo se encuentra en `models/Artist.php`

Instanciaremos nuestra tabla de la siguiente manera:

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist';
}
```

En el archivo `routes/web.php` se definirá una función básica. Dentro de esta función se verán los cuatro tipos de funciones para una tabla:

1. Create
2. Update
3. Read
4. Delete

Para cada modelo, es importante crear una nueva instancia dentro de las funciones de vista:

```php
Route::get('/prueba', function() {
	$artist = new Artist;
});
```

## Creación de registros

Dentro del modelo se definirán en forma de **propiedades** los campos que se verán sujetos a estas funciones de creación, eliminación y actualización. A estas propiedades se les asignarán valores y, posteriormente se guardarán con la función `save()`. Al final solamente se retornará el modelo para observar su comportamiento.

```php
Route::get('/prueba', function() {
	$artist = new Artist;
	// Campos que existen en la tabla "Artist" y los valores 
	// que queremos ingresar dentro de esos campos:
	$artist->name = "Primer Artista";
	$artist->alias = "Alias";
	$artist->genre = "Metal";

	// Ahora guardamos con el metodo save()
	$artist->save();
	// Retornamos para verificar que algo se haya guardado
	return $artist;
});
```

## Actualización de registros.

Para actualizar un registro, primeramente, se debe encontrar el registro a actualizar. Esto se logra gracias al método `Model::find()` donde tendrá por parámetro el id del elemento.

Un ejemplo con el modelo `Artist`

```php
$artist = Artist::find(1);
```

Si se busca encontrar un elemento o elementos en base a otro campo, como por ejemplo `name`. Al final de la consulta se usará el método `first()`, este método retorna el primer campo que cumpla con el resultado dado en la clausula `where()`.

Una vez encontrado el registro a actualizar, de la instancia del modelo (en este caso `$artist`) seleccionaremos el campo a actualizar, por ejemplo `$artist->name` y se asignará un nuevo valor.

Por último, se guarda el registro con el método `save()`.

```php
$artist = Artist::where('name', 'Primer Artista')->first();
$artist->name = 'Artista Editado';
$artist->save();

return $artist;
```

## Lectura de registros.

Para leer o traer todos los registros de una tabla usamos el método `Model::all()`, o el método `Model::get()`

```php
$artist = Artist::all();
return $artist;
```

Para traer todos los registros que cumplan con cierta condición, como un rango de valores en base al id, se debe hacer la clausula `where()`, la cual en lugar de solamente recibir dos parámetros, recibirá uno tercero, que ira **entre los dos parámetros que ya se usaban**, en este parámetro debe ir un operador lógico, como lo son =, <, >, <=, >=. Ahora en lugar de usar `->first()` como método de captura, usaremos `->get()`, este método traerá todos los registros que cumplan con la condición.

```php
$artist = Artist::where('id', '>=', '2')->get();
return $artist;
```

Para ordenar los registros en un orden en específico se usará el método `orderBy()` dentro de este se coloca el campo por el cual se ordenará y posteriormente, el tipo de orden (ascendente o descendente).

```php
$artist = Artist::orderBy('id', 'desc')->get();
return $artist;
```

Si solo se buscan obtener campos específicos de la clausula `get()`, se usa el método `select()`, dentro de este método, recibe de parámetros los campos que queremos capturar.

```php
$artist = Artist::get()->select('name', 'alias');
return $artist;
```

Si se quiere establecer un limite de registros para devolver al usuario, se utiliza el método `take()`, que, como parámetro, recibirá un numero, que representa la cantidad de registros que traerá de la tabla

```php
$artist = Artist::get()
			->select('name', 'alias')
			->take(2);
return $artist;
```

## Eliminación de registros.

Para eliminar un registro de la tabla, primeramente se deberá encontrar el elemento a eliminar. Posteriormente se usara el método `delete()`.

```php
$artist = Artist::find(1);
$artist->delete();
return "Eliminado correctamente";
```

# Convenciones.

Laravel y, principalmente, Eloquent, trabaja por convenciones, si en el modelo ``Artist`` no se hubiera definido la tabla `protected $table = 'artist'`, este simplemente tomaría el nombre del modelo, que en este ejemplo es `Artist` y lo cambiaría a plural y en minúsculas.

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    // Si no definimos nada aquí
    // $table => artists
}
```